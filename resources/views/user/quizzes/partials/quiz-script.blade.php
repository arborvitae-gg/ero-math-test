<script>
    function quizHandler() {
        return {
            previousQuestion() {
                document.getElementById('answer-form').action += '?direction=previous';
                document.getElementById('answer-form').submit();
            },
            nextQuestion() {
                document.getElementById('answer-form').action += '?direction=next';
                document.getElementById('answer-form').submit();
            }
        }
    }
</script>
