// FAQ accordion (#faq-section) — single-open, matching the React version it replaces.
//
// The server already ships the correct opened/closed state: item 1 open, items
// 2-9 with the `hidden` attribute on their answer panel. This file only moves
// items between those two states, so a visitor with JS off still reads the first
// answer and Google still crawls all nine (they back the FAQPage schema).
//
// No height animation: the panels carry an `animate-fadeIn` class that has no
// rule anywhere in front-page/css, so the bundle defines nothing to animate.
// Toggling the `hidden` attribute is the whole transition, exactly as shipped.
(function () {
    'use strict';

    // Whole-string class swaps, not per-utility toggles. Each state differs from
    // the other in five classes, and the pairs shadow-sm/shadow-xs and
    // border-zinc-300/border-zinc-200-90 must never be applied at the same time —
    // a full replace makes that impossible to get wrong.
    var WRAPPER_OPEN = 'bg-white rounded-2xl border transition-all duration-200 overflow-hidden border-zinc-300 shadow-sm ring-1 ring-zinc-200/60';
    var WRAPPER_CLOSED = 'bg-white rounded-2xl border transition-all duration-200 overflow-hidden border-zinc-200/90 hover:border-zinc-300 shadow-xs';

    // rotate-180 lives on the chevron's round wrapper, not on the svg — that is
    // what flips the icon, so the icon follows state for free with this swap.
    var ICON_OPEN = 'p-1.5 rounded-full border transition-all duration-200 flex-none bg-zinc-950 text-white border-zinc-950 rotate-180';
    var ICON_CLOSED = 'p-1.5 rounded-full border transition-all duration-200 flex-none bg-zinc-100 text-zinc-600 border-zinc-200 group-hover:border-zinc-300';

    var BUTTON_SELECTOR = 'button[id^="faq-btn-faq-"]';

    function setState(button, open) {
        var wrapper = button.parentElement;
        var panel = button.nextElementSibling;
        var svg = button.querySelector('svg.lucide-chevron-down');
        var icon = svg ? svg.parentElement : null;

        // A card missing either half is not an accordion item — leave it alone
        // rather than half-toggling it into a broken state.
        if (!wrapper || !panel) {
            return;
        }

        button.setAttribute('aria-expanded', open ? 'true' : 'false');

        // The bundle ships [hidden]{display:none!important}, so the attribute is
        // the visibility mechanism and also removes the panel from the
        // accessibility tree — no separate aria-hidden needed.
        panel.hidden = !open;

        wrapper.className = open ? WRAPPER_OPEN : WRAPPER_CLOSED;

        if (icon) {
            icon.className = open ? ICON_OPEN : ICON_CLOSED;
        }
    }

    function init() {
        var section = document.getElementById('faq-section');

        if (!section) {
            return;
        }

        // The panels ship without ids, so give each one an id derived from its
        // button and point aria-controls at it. Screen readers can then jump
        // from the question to the answer it opens.
        Array.prototype.forEach.call(section.querySelectorAll(BUTTON_SELECTOR), function (button) {
            var panel = button.nextElementSibling;

            if (!panel || button.getAttribute('aria-controls')) {
                return;
            }

            if (!panel.id) {
                panel.id = button.id.replace('faq-btn-', 'faq-panel-');
            }

            button.setAttribute('aria-controls', panel.id);
        });

        // Delegated from the section root: one listener for all nine rows, and
        // the coloured links inside a panel keep navigating normally because
        // closest() finds no header button above them.
        section.addEventListener('click', function (event) {
            var button = event.target.closest ? event.target.closest(BUTTON_SELECTOR) : null;

            if (!button || !section.contains(button)) {
                return;
            }

            var wasOpen = button.getAttribute('aria-expanded') === 'true';

            // Clicking the open row collapses it — the React version toggled,
            // so it is possible to have every row closed.
            if (wasOpen) {
                setState(button, false);
                return;
            }

            // Single-open: close whatever is open before opening this one. Read
            // the DOM rather than tracking a "current" variable, so the state on
            // screen is always the source of truth.
            Array.prototype.forEach.call(
                section.querySelectorAll(BUTTON_SELECTOR + '[aria-expanded="true"]'),
                function (open) {
                    setState(open, false);
                }
            );

            setState(button, true);
        });

        // Enter/Space are left to the native <button>. No keydown handling here
        // on purpose: intercepting them is how accordions usually break.
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
