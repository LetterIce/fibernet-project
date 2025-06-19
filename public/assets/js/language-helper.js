// Language Helper for FiberNet Project

(function() {
    'use strict';
    
    // Wait for DOM to be ready
    function ready(fn) {
        if (document.readyState !== 'loading') {
            fn();
        } else {
            document.addEventListener('DOMContentLoaded', fn);
        }
    }
    
    ready(function() {
        // Auto-detect and setup language switcher
        setupLanguageSwitcher();
    });
    
    function setupLanguageSwitcher() {
        // Find all possible language switcher elements
        const languageSwitchers = [
            // Common selectors for language dropdowns
            '[data-language]',
            '[data-lang-switch]',
            '.language-switcher',
            '.lang-switcher',
            '.dropdown-item[href*="lang"]',
            'a[href*="language"]',
            '.lang-id, .lang-en',
            // Flag-based switchers
            '.flag-id, .flag-en',
            '.country-id, .country-en'
        ];
        
        languageSwitchers.forEach(selector => {
            const elements = document.querySelectorAll(selector);
            elements.forEach(element => {
                if (!element.hasAttribute('data-lang-initialized')) {
                    element.setAttribute('data-lang-initialized', 'true');
                    element.addEventListener('click', handleLanguageClick);
                }
            });
        });
        
        // Setup mutation observer for dynamically added elements
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'childList') {
                    mutation.addedNodes.forEach(function(node) {
                        if (node.nodeType === 1) { // Element node
                            setupLanguageSwitcher();
                        }
                    });
                }
            });
        });
        
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }
    
    function handleLanguageClick(e) {
        e.preventDefault();
        
        const target = e.currentTarget;
        let langCode = null;
        
        // Try different ways to detect language
        langCode = target.getAttribute('data-language') ||
                  target.getAttribute('data-lang-switch') ||
                  target.getAttribute('data-lang') ||
                  target.getAttribute('lang');
        
        // Check class names
        if (!langCode) {
            if (target.classList.contains('lang-id') || target.classList.contains('flag-id') || target.classList.contains('country-id')) {
                langCode = 'id';
            } else if (target.classList.contains('lang-en') || target.classList.contains('flag-en') || target.classList.contains('country-en')) {
                langCode = 'en';
            }
        }
        
        // Check text content
        if (!langCode) {
            const text = target.textContent.trim().toLowerCase();
            if (text.includes('indonesia') || text === 'id' || text === 'idn') {
                langCode = 'id';
            } else if (text.includes('english') || text === 'en' || text === 'eng') {
                langCode = 'en';
            }
        }
        
        // Check href attribute
        if (!langCode && target.href) {
            if (target.href.includes('lang=id') || target.href.includes('language=id')) {
                langCode = 'id';
            } else if (target.href.includes('lang=en') || target.href.includes('language=en')) {
                langCode = 'en';
            }
        }
        
        if (langCode) {
            const targetLang = langCode.toLowerCase() === 'id' ? 'id' : 'en';
            
            // Call the switchLanguage function if it exists
            if (typeof window.switchLanguage === 'function') {
                window.switchLanguage(targetLang);
            }
            
            // Dispatch custom event
            document.dispatchEvent(new CustomEvent('languageChanged', {
                detail: { language: targetLang }
            }));
            
            console.log('Language switched to:', targetLang);
        }
    }
})();
