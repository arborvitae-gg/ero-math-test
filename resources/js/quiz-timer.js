// resources/js/quiz-timer.js
// Handles the quiz countdown timer and auto-submit logic

document.addEventListener('DOMContentLoaded', function () {
    // Only run if timer variables are present
    if (typeof window.quizRemainingTime === 'undefined' || typeof window.quizSubmitUrl === 'undefined') return;
    const timerElem = document.getElementById('quiz-timer');
    if (!timerElem) return;
    let remaining = window.quizRemainingTime || 0;
    const submitUrl = window.quizSubmitUrl;

    function formatTime(seconds) {
        const h = Math.floor(seconds / 3600);
        const m = Math.floor((seconds % 3600) / 60);
        const s = seconds % 60;
        return [h, m, s]
            .map(v => v < 10 ? '0' + v : v)
            .join(':');
    }

    function updateTimer() {
        if (remaining <= 0) {
            timerElem.textContent = '00:00:00';
            // Auto-submit the quiz via POST
            const form = document.getElementById('auto-submit-form');
            if (form) {
                form.submit();
            } else {
                // fallback: redirect (should not happen)
                window.location.href = submitUrl;
            }
            return;
        }
        timerElem.textContent = formatTime(remaining);
        remaining--;
        setTimeout(updateTimer, 1000);
    }

    updateTimer();
});
