// Header, mobile navigation, in-page anchors and the href-less CTA buttons.
//
// Everything React used to hold in onClick handlers. The prerendered HTML this
// page was rebuilt from records what a button LOOKS like but not where it went,
// so the destinations below are reconstructed, not recovered — see CTA_TARGET.
//
// The mobile panel is built here rather than in PHP because React only ever
// rendered it in its open state; there is no closed-state markup to copy. It is
// cloned from the desktop nav so the ACF repeater stays the one source of truth.
(function () {
    'use strict';

    // ---------------------------------------------------------------------
    // The single decision in this file.
    //
    // Six buttons on this page were wired by React with no href, no data-*
    // and no form action, so the prerendered fragment carries no destination
    // for any of them. #pricing-section is the reading that matches the copy
    // ("Claim Discount", "Start Subscription", "Start Streaming Now") on a page
    // whose plan picker is the conversion point — but it is a decision that
    // needs confirming, not a fact read off the markup. Change this one string
    // and all of them move together.
    // ---------------------------------------------------------------------
    var CTA_TARGET = '#pricing-section';

    // Every <button> on the page that has no destination of its own, in DOM
    // order. #pricing-checkout-btn is deliberately absent: it carries
    // data-checkout-base and belongs to landing-pricing.js.
    var CTA_SELECTORS = [
        // The header pill has no id. `.whitespace-nowrap` scoped to <header>
        // matches only the gradient "Claim Discount" button — the hamburger
        // carries neither that class nor a label. A data-* hook in header.php
        // would be steadier than a utility class; flagged in the report.
        'header button.whitespace-nowrap',
        '#hero-start-subscription-btn',
        // The trust section's only <button>, and it has no id of its own.
        '#why-us-section button',
        '#features-compact-cta-btn',
        '#how-it-works-cta-btn',
        '#start-streaming-now-cta-btn',
        // The six "Access" buttons on the showcase cards. Same story as the
        // rest: React held their destination and the prerendered markup has
        // none, so without this they are six dead buttons in the middle of the
        // page. This selector matches all six, which is why initCtas() uses
        // querySelectorAll.
        '#whats-popular-section [id^="offering-card-"] button'
    ];

    var PANEL_ID = 'landing-mobile-nav';

    // Authored from utilities that are already compiled into
    // front-page/css/landing.css — checked one by one, nothing new is needed.
    //
    // `flex` and `hidden` both sit in this list on purpose: in the bundle
    // `.hidden{display:none}` is emitted after `.flex{display:flex}`, so the
    // closed state wins on source order and toggling one class is the whole
    // open/close mechanism. `lg:hidden` lives in a later media block still, so
    // the panel can never appear at desktop width even if left open.
    var PANEL_CLASS = 'lg:hidden absolute left-0 right-0 top-full mt-2 p-2 z-50 ' +
        'flex flex-col gap-1 max-h-[70vh] overflow-y-auto ' +
        'rounded-2xl bg-zinc-950/95 backdrop-blur-xl border border-white/10 ' +
        'shadow-2xl shadow-black/60 hidden';

    // Read live on every scroll rather than cached at load: a visitor can change
    // the OS setting mid-session and the next scroll should already respect it.
    function scrollBehavior() {
        var mq = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)');

        return mq && mq.matches ? 'auto' : 'smooth';
    }

    // getElementById, not querySelector: nav hrefs come out of an ACF repeater,
    // and a value like "#foo bar" or a bare "#" would make querySelector throw
    // and take the whole delegated click handler down with it.
    function findTarget(hash) {
        if (!hash || hash.charAt(0) !== '#' || hash.length < 2) {
            return null;
        }

        return document.getElementById(hash.slice(1));
    }

    // The landing header is position:absolute, not fixed or sticky — it scrolls
    // away with the hero and never covers a section further down the page, which
    // is why nothing here subtracts a header height. If it ever gains a sticky
    // state, this function is the one place that needs the offset.
    function scrollToHash(hash) {
        var target = findTarget(hash);

        if (!target) {
            return false;
        }

        var before = window.scrollY;

        target.scrollIntoView({ behavior: scrollBehavior(), block: 'start' });

        // Smooth scrolling is not universally honoured. Some browsers ship with
        // it disabled, some extensions and accessibility tools suppress it, and
        // automated browsers routinely ignore it — verified here: on this page
        // window.scrollTo({behavior:'smooth'}) moved nothing while
        // {behavior:'auto'} moved 2000px. When that happens the request is not
        // queued for later, it is simply dropped, and the button looks broken.
        //
        // So check whether anything actually moved and fall back to an instant
        // jump if not. 250ms is comfortably longer than a frame but shorter than
        // a real smooth scroll, which will already be under way and will have
        // changed scrollY by then — so this never interrupts a working animation.
        window.setTimeout(function () {
            var moved = Math.abs(window.scrollY - before) > 1;
            var arrived = Math.abs(window.scrollY - targetTop(target)) <= 2;

            if (!moved && !arrived) {
                target.scrollIntoView({ behavior: 'auto', block: 'start' });
            }
        }, 250);

        return true;
    }

    /**
     * Where the page would sit with `target` at the top, clamped to the document.
     *
     * Needed so the fallback above can tell "the smooth scroll was ignored" from
     * "we are already there", which look identical if you only compare scrollY
     * before and after.
     */
    function targetTop(target) {
        var wanted = window.scrollY + target.getBoundingClientRect().top;
        var max = Math.max(0, document.documentElement.scrollHeight - window.innerHeight);

        return Math.min(Math.max(0, Math.round(wanted)), Math.round(max));
    }

    function wireCta(button) {
        if (!button) {
            return;
        }

        // None of these carry a `type` in the markup, so they default to
        // type="submit". They sit outside any form today; setting it from JS
        // keeps that harmless if one is ever wrapped in a form later, without
        // editing the PHP.
        button.type = 'button';

        button.addEventListener('click', function (event) {
            event.preventDefault();

            // Silent when the pricing section is not on the page — this file
            // also loads on templates that may not include every section.
            scrollToHash(CTA_TARGET);
        });
    }

    function initCtas() {
        CTA_SELECTORS.forEach(function (selector) {
            // querySelectorAll, not querySelector: CTA_SELECTORS grew a pattern
            // that matches more than one element (the six showcase cards), and
            // wiring only the first would have left five dead buttons that look
            // identical to the working one.
            var matches = document.querySelectorAll(selector);

            Array.prototype.forEach.call(matches, wireCta);
        });
    }

    // One delegated listener for every in-page link in the header (which
    // contains the mobile panel, so it is covered by the same scope) and in the
    // footer. Binding per-link would mean re-binding after the panel is built.
    function initAnchors() {
        document.addEventListener('click', function (event) {
            var link = event.target && event.target.closest ? event.target.closest('a[href]') : null;

            if (!link || !link.closest('header, #ibo-footer')) {
                return;
            }

            // A hash that points at nothing on this page keeps its default
            // behaviour: a dud link should still behave like a dud link rather
            // than silently swallowing the click.
            if (scrollToHash(link.getAttribute('href'))) {
                event.preventDefault();
            }
        });
    }

    function initMobileNav() {
        var header = document.querySelector('header');

        if (!header) {
            return;
        }

        var toggle = header.querySelector('button.lg\\:hidden');
        var desktopNav = header.querySelector('nav');

        // All three checks are the same guard: without a hamburger, a nav to
        // copy, or with a panel already built, there is nothing to do.
        if (!toggle || !desktopNav || document.getElementById(PANEL_ID)) {
            return;
        }

        var links = desktopNav.querySelectorAll('a[href]');

        if (!links.length) {
            return;
        }

        var panel = document.createElement('div');

        panel.id = PANEL_ID;
        panel.className = PANEL_CLASS;

        Array.prototype.forEach.call(links, function (link) {
            // Cloned rather than rebuilt from a data array: the nav is an ACF
            // repeater, so the rendered desktop list is the single source of
            // truth for label, href and classes. Cloning also copies the label
            // as a text node, so no ACF string is ever parsed as markup.
            var item = link.cloneNode(true);

            // The only deliberate deviation from the desktop pill: py-3.5 over
            // text-xs/line-height-1rem measures 44px, the tap target the
            // hamburger itself uses (min-h-[44px]). py-1.5 is removed rather
            // than just adding py-3.5, because with both present the winner
            // would be whichever Tailwind happened to emit last, not intent.
            item.classList.remove('py-1.5');
            item.classList.add('block', 'py-3.5');

            panel.appendChild(item);
        });

        // Appended to the hamburger's own parent — the pill <div>, which is the
        // only position:relative box in the header — so `absolute top-full`
        // hangs the panel directly under the pill at any width.
        toggle.parentNode.appendChild(panel);

        toggle.type = 'button';
        toggle.setAttribute('aria-controls', PANEL_ID);
        toggle.setAttribute('aria-expanded', 'false');

        function isOpen() {
            return !panel.classList.contains('hidden');
        }

        function setOpen(open, returnFocus) {
            panel.classList.toggle('hidden', !open);
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');

            if (open) {
                var first = panel.querySelector('a[href]');

                if (first) {
                    first.focus();
                }
            } else if (returnFocus) {
                toggle.focus();
            }
        }

        // The hamburger sits before the panel in the DOM, so looping across
        // [toggle, ...links] traps focus in the order a reader would tab through
        // anyway — and Shift+Tab off the first link lands on the control that
        // opened the panel instead of escaping behind it.
        function focusLoop() {
            return [toggle].concat(Array.prototype.slice.call(panel.querySelectorAll('a[href]')));
        }

        document.addEventListener('keydown', function (event) {
            if (!isOpen()) {
                return;
            }

            // 'Esc' as well as 'Escape': older Edge and Firefox report the short
            // form and this is cheaper than a keyCode fallback.
            if (event.key === 'Escape' || event.key === 'Esc') {
                setOpen(false, true);

                return;
            }

            if (event.key !== 'Tab') {
                return;
            }

            var loop = focusLoop();
            var index = loop.indexOf(document.activeElement);

            event.preventDefault();

            // Focus somewhere outside the loop (a stray programmatic focus, or
            // the page body) is pulled back to the start rather than allowed to
            // wander out of an open modal panel.
            if (index === -1) {
                loop[0].focus();

                return;
            }

            var next = event.shiftKey ? index - 1 : index + 1;

            if (next < 0) {
                next = loop.length - 1;
            } else if (next >= loop.length) {
                next = 0;
            }

            loop[next].focus();
        });

        toggle.addEventListener('click', function (event) {
            event.preventDefault();
            setOpen(!isOpen(), false);
        });

        document.addEventListener('click', function (event) {
            if (!isOpen()) {
                return;
            }

            var target = event.target;

            // The hamburger has its own handler above. Ignoring it here is what
            // stops the same click from opening and then immediately closing.
            if (toggle.contains(target)) {
                return;
            }

            if (!panel.contains(target)) {
                setOpen(false, false);

                return;
            }

            // Any link inside closes the panel. Whether that link scrolls or
            // navigates has already been decided by the anchor listener.
            if (target.closest && target.closest('a[href]')) {
                setOpen(false, false);
            }
        });

        // At lg the hamburger is display:none and so is the panel, which would
        // leave keyboard focus trapped inside something invisible. Closing on
        // the breakpoint change is the only reason this listener exists — the
        // header itself has a single visual state and needs no scroll or resize
        // handling. offsetParent is null exactly when the toggle is not rendered.
        // Debounced: the body reads offsetParent, which forces a synchronous
        // layout, and resize fires continuously while a window is dragged. The
        // only thing being watched for is the breakpoint crossing that hides the
        // hamburger, so answering once the drag settles is enough.
        var resizeTimer = null;

        window.addEventListener('resize', function () {
            if (resizeTimer) {
                window.clearTimeout(resizeTimer);
            }

            resizeTimer = window.setTimeout(function () {
                resizeTimer = null;

                if (isOpen() && toggle.offsetParent === null) {
                    setOpen(false, false);
                }
            }, 150);
        });
    }

    /**
     * The footer's three column accordions.
     *
     * Each heading is a <button> followed by a <ul class="... hidden md:block">.
     * From 768px up the md: rule shows the list and the button is inert by
     * design (md:cursor-default). Below that the list is hidden and nothing ever
     * unhid it: fourteen footer links — every legal page, the guide, the blog,
     * the M3U converter — were present in the HTML but unreachable on a phone,
     * which is most of this site's traffic.
     *
     * Toggling `hidden` is enough. `md:block` still wins above the breakpoint,
     * so a column left closed on mobile is still open on desktop, and a column
     * opened on mobile does not leak a stray inline style into the desktop
     * layout.
     */
    function initFooterAccordions(footer) {
        var buttons = footer.querySelectorAll('button.md\\:cursor-default');

        Array.prototype.forEach.call(buttons, function (button) {
            var list = button.nextElementSibling;

            if (!list || list.tagName !== 'UL') {
                return;
            }

            // Truthful from the start: on mobile these render closed.
            button.setAttribute('aria-expanded', list.classList.contains('hidden') ? 'false' : 'true');

            button.addEventListener('click', function (event) {
                event.preventDefault();

                var nowHidden = list.classList.toggle('hidden');
                button.setAttribute('aria-expanded', nowHidden ? 'false' : 'true');
            });
        });
    }

    function initBackToTop() {
        var footer = document.getElementById('ibo-footer');

        if (!footer) {
            return;
        }

        initFooterAccordions(footer);

        // Keyed off the icon, not aria-label="Scroll to top": the label is ACF
        // and translatable, while lucide-arrow-up appears exactly once in the
        // footer and is not user-editable.
        var icon = footer.querySelector('svg.lucide-arrow-up');
        var button = icon && icon.closest ? icon.closest('button') : null;

        if (!button) {
            return;
        }

        button.addEventListener('click', function (event) {
            event.preventDefault();
            window.scrollTo({ top: 0, behavior: scrollBehavior() });
        });
    }

    // Tells front-page/js/landing-footer.js to stand down. That file carries the
    // footer half of this one for templates that do not load landing-nav.js; if
    // both bound the accordions, every click would toggle a column twice.
    window.iptvLandingNavLoaded = true;

    function init() {
        // Mobile nav first: it appends the panel into the header, and the anchor
        // listener is scoped to the header, so the panel's links are covered
        // without a second binding pass.
        initMobileNav();
        initAnchors();
        initCtas();
        initBackToTop();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
