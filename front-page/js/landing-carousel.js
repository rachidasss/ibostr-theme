/**
 * Horizontal carousels for the v2 landing sections.
 *
 * Drives two rails that share one pattern — a native scroll track plus arrow
 * buttons — from a single implementation:
 *
 *   #whats-popular-section  header prev/next + a floating overlay next, an
 *                           "01 / 06" counter and a right-edge fade.
 *   #reviews-section        one overlay arrow, no counter, no fade; it wraps
 *                           back to the start instead of disabling, because
 *                           the design has no left arrow to come back with.
 *
 * The tracks scroll natively (overflow-x-auto + scroll-snap), so dragging or
 * flicking the rail directly keeps the counter and the button states in sync
 * for free — everything reads back off scrollLeft rather than a stored index.
 *
 * No dependencies. Nothing added to window.
 */
(function () {
    'use strict';

    // The header prev/next buttons carry their whole visual state in the class
    // attribute, so switching state is a full replace of the trailing half —
    // toggling one class would leave the other state's colours behind.
    var BTN_BASE = 'min-h-[44px] min-w-[44px] p-2.5 rounded-full border transition-all duration-200 shadow-md active:scale-95 flex items-center justify-center';
    var BTN_OFF = 'bg-zinc-900/50 border-zinc-800/50 text-zinc-600 cursor-not-allowed opacity-40';
    var BTN_ON = 'bg-zinc-900 border-zinc-700 hover:bg-[#007CEB] hover:text-white hover:border-blue-500 text-zinc-200 cursor-pointer';

    // Pointer travel, in px, past which a press counts as a pan rather than a
    // click. Below it the press must still reach the card's Access button.
    var DRAG_SLOP = 5;

    // scrollWidth/clientWidth are rounded to integers while scrollLeft is
    // fractional, so a rail scrolled fully right can land ~0.5px short of its
    // own maximum. Without this slack "at end" is never true on fractional-DPI
    // displays and the fade never hides.
    var EDGE = 1;

    var CAROUSELS = [
        {
            section: '#whats-popular-section',
            prev: 'button[aria-label="Scroll Left"]',
            next: 'button[aria-label="Scroll Right"]',
            overlay: 'button[aria-label="Scroll Carousel Right"]',
            fade: '.pointer-events-none.absolute.right-0',
            counter: '.font-mono',
            // Only this section's header buttons own the disabled class pair
            // above; the overlay arrow has a completely different class list
            // and hides instead.
            statefulButtons: true,
            wrap: false
        },
        {
            section: '#reviews-section',
            overlay: '#reviews-overlay-right',
            statefulButtons: false,
            wrap: true
        }
    ];

    function prefersReducedMotion() {
        return !!(window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches);
    }

    function pad2(n) {
        return String(n).padStart(2, '0');
    }

    function init(cfg) {
        var root = document.querySelector(cfg.section);
        if (!root) return; // section not on this template

        // Every track in these sections is the single .overflow-x-auto child.
        var track = root.querySelector('.overflow-x-auto');
        if (!track) return;

        var prevBtn = cfg.prev ? root.querySelector(cfg.prev) : null;
        var nextBtn = cfg.next ? root.querySelector(cfg.next) : null;
        var overlay = cfg.overlay ? root.querySelector(cfg.overlay) : null;
        var fade = cfg.fade ? root.querySelector(cfg.fade) : null;
        // The counter pill is "<span>01</span><span>/</span><span>06</span>";
        // only the first span is ours to write.
        var counter = cfg.counter ? root.querySelector(cfg.counter) : null;
        var counterValue = counter ? counter.querySelector('span') : null;

        // Only direct children: the reviews cards nest .snap-start-free markup,
        // and a descendant match would corrupt the step measurement.
        function slides() {
            return track.querySelectorAll(':scope > .snap-start');
        }

        // Card widths are responsive (170/190/205px here, 270/300px there) with
        // a gap that also changes at sm:, so the step is measured every time
        // rather than cached or hardcoded — that is what makes a breakpoint
        // change need no more than a re-render.
        function step() {
            var s = slides();
            if (!s.length) return track.clientWidth;
            if (s.length > 1) {
                // offsetLeft is measured against the same offsetParent for both
                // and is unaffected by scrolling, so the difference is the true
                // pitch including whatever the gap currently resolves to.
                var pitch = s[1].offsetLeft - s[0].offsetLeft;
                if (pitch > 0) return pitch;
            }
            var gap = parseFloat(window.getComputedStyle(track).columnGap);
            return s[0].getBoundingClientRect().width + (isNaN(gap) ? 0 : gap);
        }

        function maxScroll() {
            return track.scrollWidth - track.clientWidth;
        }

        function atEnd() {
            return track.scrollLeft >= maxScroll() - EDGE;
        }

        function overflows() {
            return maxScroll() > EDGE;
        }

        // CSS puts scroll-behavior:smooth on the track. Per spec a scrollBy of
        // behavior:'auto' defers to that CSS rather than jumping, so honouring
        // prefers-reduced-motion means killing the CSS with an inline override
        // as well as passing 'auto'.
        function syncScrollBehavior() {
            track.style.scrollBehavior = prefersReducedMotion() ? 'auto' : '';
        }

        function behavior() {
            syncScrollBehavior();
            return prefersReducedMotion() ? 'auto' : 'smooth';
        }

        function setButtonState(btn, off) {
            if (!btn || btn.disabled === off) return; // avoid a style recalc per scroll frame
            btn.className = BTN_BASE + ' ' + (off ? BTN_OFF : BTN_ON);
            btn.disabled = off; // assigning false removes the attribute entirely
        }

        function setHidden(el, hide) {
            if (el) el.classList.toggle('hidden', hide);
        }

        function sync() {
            var end = atEnd();
            var scrollable = overflows();

            if (counterValue) {
                var pitch = step();
                var count = slides().length;
                // Index of the slide nearest the left edge, clamped so a rubber
                // band overscroll cannot print "07 / 06".
                var index = pitch > 0 ? Math.round(track.scrollLeft / pitch) + 1 : 1;
                if (count) index = Math.min(Math.max(index, 1), count);
                counterValue.textContent = pad2(index);
                // The total span is server-rendered from count($lp_showcase_rows)
                // and is never touched here.
            }

            if (cfg.statefulButtons) {
                // A rail that does not overflow reports both edges at once, so
                // both buttons fall out disabled with no extra branch.
                setButtonState(prevBtn, track.scrollLeft <= EDGE);
                setButtonState(nextBtn, end);
            }

            // The overlay arrow and the fade are decoration over the right
            // edge: pointless once there is no more track to reveal. The wrap
            // rail keeps its arrow at the end because that arrow restarts it.
            var hideRightEdge = !scrollable || (end && !cfg.wrap);
            setHidden(overlay, hideRightEdge);
            setHidden(fade, hideRightEdge);
        }

        function go(direction) {
            if (cfg.wrap && direction > 0 && atEnd()) {
                track.scrollTo({ left: 0, behavior: behavior() });
                return;
            }
            track.scrollBy({ left: direction * step(), behavior: behavior() });
        }

        // One delegated listener instead of one per button. Access buttons
        // inside the cards also match closest('button') but match neither
        // arrow, so they fall through untouched.
        root.addEventListener('click', function (e) {
            var btn = e.target.closest && e.target.closest('button');
            if (!btn) return;
            if (btn === prevBtn) go(-1);
            else if (btn === nextBtn || btn === overlay) go(1);
        });

        // A scrollable region has to be reachable by keyboard (WCAG 2.1.1);
        // the markup ships no tabindex, so add one rather than change the PHP.
        if (!track.hasAttribute('tabindex')) track.setAttribute('tabindex', '0');

        track.addEventListener('keydown', function (e) {
            if (e.key !== 'ArrowLeft' && e.key !== 'ArrowRight') return;
            // Only when the rail itself has focus — never steal arrows from a
            // button or link inside a card.
            if (e.target !== track) return;
            e.preventDefault(); // replace the browser's few-pixel nudge with a whole card
            go(e.key === 'ArrowRight' ? 1 : -1);
        });

        var ticking = false;
        track.addEventListener('scroll', function () {
            if (ticking) return;
            ticking = true;
            window.requestAnimationFrame(function () {
                ticking = false;
                sync();
            });
        }, { passive: true });

        var resizeTimer;
        window.addEventListener('resize', function () {
            window.clearTimeout(resizeTimer);
            // Debounced: a resize storm would otherwise re-measure per frame.
            // Only sync() is needed — step() is measured on demand, so the new
            // breakpoint's card width is picked up by the next interaction.
            resizeTimer = window.setTimeout(sync, 150);
        });

        // --- drag to pan -----------------------------------------------------
        // Both tracks carry cursor-grab / active:cursor-grabbing, so the grab
        // cursor has to be backed by real panning.
        var drag = null;
        var swallowClick = false;

        track.addEventListener('pointerdown', function (e) {
            // Touch already scrolls natively with momentum; intercepting it
            // makes the rail feel broken on iOS.
            if (e.pointerType === 'touch' || e.button !== 0) return;
            // A pan that ended without a following click would otherwise leave
            // this armed and eat the next real click on a card.
            swallowClick = false;
            drag = { id: e.pointerId, x: e.clientX, left: track.scrollLeft, panning: false };
        });

        track.addEventListener('pointermove', function (e) {
            if (!drag || e.pointerId !== drag.id) return;
            var dx = e.clientX - drag.x;

            if (!drag.panning) {
                if (Math.abs(dx) <= DRAG_SLOP) return;
                drag.panning = true;
                // Capture only once it is definitely a pan, so a plain click
                // still gets delivered to the card button under the pointer.
                track.setPointerCapture(e.pointerId);
                // Smooth scrolling animates towards a target and so fights a
                // per-pixel assignment; switch it off for the duration.
                track.style.scrollBehavior = 'auto';
            }

            track.scrollLeft = drag.left - dx;
        });

        function endDrag(e) {
            if (!drag || e.pointerId !== drag.id) return;
            var panned = drag.panning;
            drag = null;
            if (!panned) return;
            if (track.hasPointerCapture(e.pointerId)) track.releasePointerCapture(e.pointerId);
            syncScrollBehavior(); // restore, respecting the motion preference
            swallowClick = true;
        }

        track.addEventListener('pointerup', endDrag);
        track.addEventListener('pointercancel', endDrag);

        // Capture phase, so the click ending a pan dies before it reaches the
        // card's Access button or the delegated arrow handler above.
        track.addEventListener('click', function (e) {
            if (!swallowClick) return;
            swallowClick = false;
            e.preventDefault();
            e.stopPropagation();
        }, true);

        syncScrollBehavior();
        sync();
    }

    function start() {
        CAROUSELS.forEach(init);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', start);
    } else {
        start();
    }
}());
