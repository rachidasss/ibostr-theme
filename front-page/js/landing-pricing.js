/**
 * Landing page — plan configurator (#pricing-section).
 *
 * Restores what React used to do: pick a screen count (1–4) and a duration
 * (1/3/6/12 months), and the whole panel follows — both pickers' selected
 * state, the four duration cards, the savings badges, the YOUR TOTAL block and
 * the checkout URL.
 *
 * PRICES ARE NEVER HARDCODED HERE. Two sources, in order:
 *
 *   1. window.iptvPrices — the theme's existing localized matrix
 *      (IPTV_Currency_Settings::get_price_table(), shaped
 *      [duration_key][device_key][currency]), read the same way
 *      front-page/js/pricing.js reads it.
 *
 *   2. The rendered duration cards. These only carry ONE screen column — the
 *      one the server rendered — because sections-v2/pricing.php prints the
 *      1-screen ladder and nothing else. So without (1), a change of screen
 *      count cannot be repriced: the numbers are then left exactly as the
 *      server rendered them rather than faked, and only the picker state and
 *      the checkout URL follow the click. See the README note at the bottom.
 *
 * Money formatting is lifted from whatever the server already printed
 * ("$13.99", "13,99 kr", "one-time · $5.00/mo"), so a currency or language
 * change needs no table in here.
 */
(function () {
    'use strict';

    var SCREENS = [1, 2, 3, 4];
    var MONTHS = [1, 3, 6, 12];

    // Keys of IPTV_Currency_Settings' matrix.
    var DUR_KEY = { 1: '1_month', 3: '3_months', 6: '6_months', 12: '12_months' };
    var DEV_KEY = { 1: '1_device', 2: '2_devices', 3: '3_devices', 4: '4_devices' };

    // Only the state half of each class string. Everything up to and including
    // `border` is shared between both states and must survive every swap.
    var SCREEN_ON = ['bg-slate-950', 'text-white', 'border-slate-950', 'shadow-md', 'scale-[1.01]'];
    var SCREEN_OFF = ['bg-slate-50', 'text-slate-700', 'border-slate-200', 'hover:bg-slate-100'];
    var DUR_ON = ['bg-[#007CEB]', 'text-white', 'border-[#007CEB]', 'shadow-md', 'scale-[1.01]'];
    var DUR_OFF = ['bg-slate-50', 'text-slate-900', 'border-slate-200', 'hover:bg-slate-100'];
    var BADGE_ON = ['bg-slate-950', 'text-white'];
    var BADGE_OFF = ['bg-slate-200', 'text-slate-700'];
    var LABEL_ON = ['text-white/80'];
    var LABEL_OFF = ['text-slate-500'];
    var PER_ON = ['text-white/90'];
    var PER_OFF = ['text-slate-500'];

    var SEL_LABEL = '.text-\\[9px\\].font-bold';
    var SEL_PER = '.text-\\[9px\\].font-mono';
    var SEL_PRICE = '.font-heading.font-black.text-sm';

    /* ── money ─────────────────────────────────────────────────────────────
     * A "template" is a server-rendered string with its numbers pulled out, so
     * we can put new numbers back without knowing the currency symbol, its
     * side, the decimal separator, how many decimals it uses, or what language
     * the words around it are in.
     */
    var NUM = /-?\d+(?:[.,]\d+)?/g;

    function template(text) {
        var parts = [];
        var slots = [];
        var last = 0;
        var m;

        NUM.lastIndex = 0;
        while ((m = NUM.exec(text)) !== null) {
            var raw = m[0];
            var at = raw.search(/[.,]/);

            parts.push(text.slice(last, m.index));
            slots.push({
                decimals: at === -1 ? 0 : raw.length - at - 1,
                sep: at === -1 ? '.' : raw.charAt(at),
                value: parseFloat(raw.replace(',', '.'))
            });
            last = m.index + raw.length;
        }

        if (!slots.length) return null;
        parts.push(text.slice(last));

        return { parts: parts, slots: slots };
    }

    // Slots the caller does not override keep the number the server printed, so
    // digits that are part of the copy ("1-Click Access · $59.99") stay put.
    function render(tpl, values) {
        var out = tpl.parts[0];

        for (var i = 0; i < tpl.slots.length; i++) {
            var slot = tpl.slots[i];
            var n = (values && i in values) ? values[i] : slot.value;

            out += n.toFixed(slot.decimals).replace('.', slot.sep) + tpl.parts[i + 1];
        }

        return out;
    }

    // The common case: one money figure, and it is the last number in the line.
    function renderLast(tpl, n) {
        var v = {};
        v[tpl.slots.length - 1] = n;
        return render(tpl, v);
    }

    function textOf(el) {
        return el ? el.textContent.trim() : '';
    }

    function templateOf(el) {
        return el ? template(el.textContent) : null;
    }

    function write(el, tpl, n) {
        if (el && tpl) el.textContent = renderLast(tpl, n);
    }

    // saving / was, as a whole percent. Clamped at zero so a 1-month plan (where
    // "was" equals "now") can never render -0.00 or a negative badge.
    function savingPct(now, monthly, months) {
        var was = monthly * months;
        return was > 0 ? Math.round(Math.max(0, was - now) / was * 100) : 0;
    }

    /* ── class state ─────────────────────────────────────────────────────── */

    // Remove the losing set before adding the winning one: the two sets are
    // disjoint today, but if a token ever appeared in both, removing last would
    // strip the class the new state needs.
    function paint(el, on, onCls, offCls) {
        if (!el) return;
        el.classList.remove.apply(el.classList, on ? offCls : onCls);
        el.classList.add.apply(el.classList, on ? onCls : offCls);
    }

    /* ── boot ────────────────────────────────────────────────────────────── */

    function init() {
        var root = document.getElementById('pricing-section');
        if (!root) return;

        // The two pickers are the only 4-up grids in the section; the feature
        // checklist below them is grid-cols-1 sm:grid-cols-2.
        var grids = root.querySelectorAll('.grid.grid-cols-2.sm\\:grid-cols-4.gap-2');
        if (grids.length < 2) return;

        var screenBtns = buttonsIn(grids[0]);
        var durBtns = buttonsIn(grids[1]);
        if (screenBtns.length !== 4 || durBtns.length !== 4) return;

        var checkoutBtn = document.getElementById('pricing-checkout-btn');

        // Values come from each button's own label ("3 Months" → 3) so a
        // reordered or translated ACF repeater still sends the right plan to
        // checkout; position is only the fallback.
        var screenVals = screenBtns.map(function (btn, i) {
            return valueIn(btn.querySelector('span:not(.absolute)'), SCREENS, SCREENS[i]);
        });
        var monthVals = durBtns.map(function (btn, i) {
            return valueIn(btn.querySelector(SEL_LABEL), MONTHS, MONTHS[i]);
        });

        var parts = durBtns.map(function (btn) {
            return {
                badge: btn.querySelector('.absolute'),
                label: btn.querySelector(SEL_LABEL),
                per: btn.querySelector(SEL_PER),
                price: btn.querySelector(SEL_PRICE)
            };
        });

        var panel = {
            pill: root.querySelector('.text-emerald-400.font-mono'),
            total: root.querySelector('span.font-heading.font-black.text-2xl'),
            strike: root.querySelector('span.line-through'),
            note: root.querySelector('div.text-slate-400.font-mono'),
            cta: checkoutBtn ? checkoutBtn.querySelector('span.whitespace-nowrap') : null
        };

        // Templates are captured from the untouched server render, so they must
        // be read before anything writes to those nodes.
        var tpl = {
            badge: parts.map(function (p) { return templateOf(p.badge); }),
            per: parts.map(function (p) { return templateOf(p.per); }),
            price: parts.map(function (p) { return templateOf(p.price); }),
            pill: templateOf(panel.pill),
            total: templateOf(panel.total),
            strike: templateOf(panel.strike),
            note: templateOf(panel.note),
            cta: templateOf(panel.cta)
        };

        var selScreen = indexOfSelected(screenBtns, SCREEN_ON[0], 0);
        var selDur = indexOfSelected(durBtns, DUR_ON[0], MONTHS.length - 1);

        // Fallback column: the ladder the server actually printed. It belongs to
        // whichever screen count was rendered as selected, and to no other.
        var domCol = columnFromDom(tpl.price, monthVals);
        var domScreens = screenVals[selScreen];

        function column(screens) {
            return localizedColumn(screens) || (screens === domScreens ? domCol : null);
        }

        function apply() {
            var screens = screenVals[selScreen];
            var months = monthVals[selDur];

            // Picker state and the checkout URL are updated first and
            // unconditionally: they must stay truthful even when we have no
            // prices for the chosen column.
            screenBtns.forEach(function (btn, i) {
                var on = i === selScreen;
                paint(btn, on, SCREEN_ON, SCREEN_OFF);
                btn.setAttribute('aria-pressed', on ? 'true' : 'false');
            });

            durBtns.forEach(function (btn, i) {
                var on = i === selDur;
                paint(btn, on, DUR_ON, DUR_OFF);
                paint(parts[i].badge, on, BADGE_ON, BADGE_OFF);
                paint(parts[i].label, on, LABEL_ON, LABEL_OFF);
                paint(parts[i].per, on, PER_ON, PER_OFF);
                btn.setAttribute('aria-pressed', on ? 'true' : 'false');
            });

            updateCheckoutUrl(screens, months);

            var col = column(screens);
            if (!col) return; // no data for this column — keep the rendered numbers

            var monthly = col[1];
            var now = col[months];

            parts.forEach(function (p, i) {
                var m = monthVals[i];
                var price = col[m];
                if (price === undefined) return;

                write(p.price, tpl.price[i], price);
                write(p.per, tpl.per[i], price / m);

                // Badge copy is the editor's. Rewrite it only when it already
                // states a percentage, so "Best value" survives and the
                // badge-less 1-month button never gains one.
                if (p.badge && tpl.badge[i] && /%/.test(textOf(p.badge))) {
                    var pct = savingPct(price, monthly, m);
                    p.badge.classList.toggle('hidden', pct <= 0);
                    if (pct > 0) p.badge.textContent = renderLast(tpl.badge[i], pct);
                }
            });

            var was = monthly * months;
            var saving = Math.max(0, was - now);
            var pct = savingPct(now, monthly, months);

            write(panel.total, tpl.total, now);
            write(panel.strike, tpl.strike, was);
            write(panel.note, tpl.note, now / months);
            write(panel.cta, tpl.cta, now);

            // At 1 month there is nothing to save, and a struck-through price
            // identical to the total reads as a bug.
            if (panel.strike) panel.strike.classList.toggle('hidden', saving <= 0);

            if (panel.pill && tpl.pill && tpl.pill.slots.length === 2) {
                panel.pill.classList.toggle('hidden', saving <= 0);
                if (saving > 0) panel.pill.textContent = render(tpl.pill, { 0: saving, 1: pct });
            }
        }

        function updateCheckoutUrl(screens, months) {
            if (!checkoutBtn) return;

            var base = checkoutBtn.getAttribute('data-checkout-base');
            if (!base) return; // Site Config owns the host; never guess a relative one

            try {
                var url = new URL(base, window.location.href);

                // set(), not a rebuilt query string: anything Site Config hung on
                // the base (utm_*, plan_type, source…) has to survive.
                url.searchParams.set('connections', String(screens));
                url.searchParams.set('duration', String(months));
                checkoutBtn.setAttribute('data-checkout-url', url.toString());
            } catch (e) {
                checkoutBtn.removeAttribute('data-checkout-url');
            }
        }

        grids[0].addEventListener('click', function (ev) {
            var i = hitIndex(ev, screenBtns);
            if (i < 0 || i === selScreen) return;
            selScreen = i;
            apply();
        });

        grids[1].addEventListener('click', function (ev) {
            var i = hitIndex(ev, durBtns);
            if (i < 0 || i === selDur) return;
            selDur = i;
            apply();
        });

        if (checkoutBtn) {
            checkoutBtn.addEventListener('click', function () {
                var href = checkoutBtn.getAttribute('data-checkout-url');
                if (href) window.location.assign(href);
            });
        }

        selfCheck();
        apply();

        /* ── helpers that need the closure ─────────────────────────────── */

        function columnFromDom(priceTpls, months) {
            var col = {};

            for (var i = 0; i < priceTpls.length; i++) {
                var t = priceTpls[i];
                if (!t) return null;

                var n = t.slots[t.slots.length - 1].value;
                if (!isFinite(n) || n <= 0) return null;

                col[months[i]] = n;
            }

            return col[1] > 0 ? col : null; // the 1-month rate anchors every saving
        }

        // The server rendered the initial state, so our arithmetic has to
        // reproduce it exactly. A mismatch means the price table and the copy
        // disagree, or this file drifted — both worth shouting about on a page
        // that takes money.
        function selfCheck() {
            var col = column(screenVals[selScreen]);
            if (!col) return;

            var months = monthVals[selDur];
            var now = col[months];
            var expect = [
                [panel.total, tpl.total, now],
                [panel.strike, tpl.strike, col[1] * months],
                [panel.note, tpl.note, now / months],
                [panel.cta, tpl.cta, now]
            ];

            for (var i = 0; i < expect.length; i++) {
                var el = expect[i][0], t = expect[i][1];
                if (!el || !t) continue;

                var got = renderLast(t, expect[i][2]);
                if (got.trim() !== el.textContent.trim()) {
                    window.console && console.warn(
                        '[landing-pricing] rendered copy disagrees with the price table:',
                        el.textContent.trim(), '≠', got.trim()
                    );
                }
            }
        }
    }

    /* ── plain helpers ───────────────────────────────────────────────────── */

    function buttonsIn(grid) {
        return Array.prototype.filter.call(grid.children, function (el) {
            return el.tagName === 'BUTTON';
        });
    }

    function valueIn(el, allowed, fallback) {
        var m = el ? /\d+/.exec(el.textContent) : null;
        var n = m ? parseInt(m[0], 10) : NaN;
        return allowed.indexOf(n) > -1 ? n : fallback;
    }

    function indexOfSelected(btns, marker, fallback) {
        for (var i = 0; i < btns.length; i++) {
            if (btns[i].classList.contains(marker)) return i;
        }
        return fallback;
    }

    function hitIndex(ev, btns) {
        var el = ev.target;
        var btn = el && el.closest ? el.closest('button') : null;
        return btn ? btns.indexOf(btn) : -1;
    }

    function localizedColumn(screens) {
        var table = window.iptvPrices;
        if (!table) return null;

        var currency = window.currentCurrency || 'usd';
        var col = {};

        for (var i = 0; i < MONTHS.length; i++) {
            var months = MONTHS[i];
            var row = table[DUR_KEY[months]];
            var cell = row ? row[DEV_KEY[screens]] : null;
            var n = parseFloat(cell && typeof cell === 'object' ? cell[currency] : cell);

            if (!isFinite(n) || n <= 0) return null; // partial table is no table
            col[months] = n;
        }

        return col;
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
}());
