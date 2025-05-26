<script>
    function quizHandler() {
        return {
            previousQuestion() {
                const form = document.getElementById('answer-form');
                const directionInput = document.createElement('input');
                directionInput.type = 'hidden';
                directionInput.name = 'direction';
                directionInput.value = 'previous';
                form.appendChild(directionInput);
                form.submit();
            },
            nextQuestion() {
                const form = document.getElementById('answer-form');
                const directionInput = document.createElement('input');
                directionInput.type = 'hidden';
                directionInput.name = 'direction';
                directionInput.value = 'next';
                form.appendChild(directionInput);
                form.submit();
            }
        }
    }
</script>
