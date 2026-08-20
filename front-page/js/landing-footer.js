/**
 * The landing footer's own behaviour, for pages that do not load landing-nav.js.
 *
 * The landing template gets this from front-page/js/landing-nav.js, which also
 * drives the landing header's mobile panel, anchor scrolling and CTAs. The
 * legacy templates use a different header, so loading that file there would set
 * those handlers loose on markup they were not written for. This carries only
 * the two things the footer itself needs.
 *
 * Keep the behaviour identical to landing-nav.js — if one changes, change both.
 */
(function () {
    'use strict';

    function scrollBehavior() {
        var mq = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)');

        return mq && mq.matches ? 'auto' : 'smooth';
    }

    /**
     * The footer's column accordions.
     *
     * Each heading is a <button> followed by a <ul class="... hidden md:block">.
     * From 768px up the md: rule shows the list and the button is inert by
     * design. Below that the list is hidden and nothing else ever unhides it, so
     * without this every footer link is present in the HTML but unreachable on a
     * phone.
     *
     * Toggling `hidden` is enough: md:block still wins above the breakpoint, so
     * a column left closed on mobile is still open on desktop, and one opened on
     * mobile leaks no inline style into the desktop layout.
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

    function initBackToTop(footer) {
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

    function init() {
        var footer = document.getElementById('ibo-footer');

        if (!footer) {
            return;
        }

        // landing-nav.js already binds these on the landing template. Binding a
        // second time would toggle each column twice per click, so stand down.
        if (window.iptvLandingNavLoaded) {
            return;
        }

        initFooterAccordions(footer);
        initBackToTop(footer);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
