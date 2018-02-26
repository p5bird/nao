$( document ).ready(function() {
    function QuizQuestion(question, choices, correctAnswer){
        this.question = question;
        this.choices = choices;
        this.correctAnswer = correctAnswer;
    }

    var allQuestions = [
        new QuizQuestion("Question 1",["1", "2", "3", "4"],4),
        new QuizQuestion("Question 2",["1", "2", "3", "4"],0),
        new QuizQuestion("Question 3",["1", "2", "3", "4"],1),
        new QuizQuestion("Question 4",["1", "2", "3", "4"],0),
        new QuizQuestion("Question 5",["1", "2", "3", "4"],0),
        new QuizQuestion("Question 6",["1", "2", "3", "4"],0),
        new QuizQuestion("Question 7",["1", "2", "3", "4"],0),
        new QuizQuestion("Question 8",["1", "2", "3", "4"],0),
    ];

    var currentquestion = 0;
    var correctAnswers = 0;

    function setupOptions() {
        $('#question').html(parseInt(currentquestion) + 1 + ". " + allQuestions[currentquestion].question);
        var options = allQuestions[currentquestion].choices;
        var formHtml = '';
        for (var i = 0; i < options.length; i++) {
            formHtml += '<div><input type="radio" name="option" value="' + i + '" class="options"><label for="option' + i + '">' + options[i] + '</label></div><br/>';
        }
        $('#form').html(formHtml);
        $(".options:eq(0)").prop('checked', true);
    }

    function checkAns() {
        if ($("input[name=option]:checked").val() == allQuestions[currentquestion].correctAnswer) {
            correctAnswers++;
        }
    }

    $(document).ready(function(){

        var $questions = $(".questions");
        var $start = $("#start");
        var $progressbar = $("#progressbar");
        var $next = $("#next");
        var $result = $("#result");

        $questions.hide();
        $start.click(function() {
            $questions.fadeIn();
            $(this).hide();
        });

        $(function() {
            $progressbar.progressbar({
                max: allQuestions.length-1,
                value: 0
            });
        });

        setupOptions();

        $next.click(function(){
            event.preventDefault();
            checkAns();
            currentquestion++;
            $(function() {
                $progressbar.progressbar({
                    value: currentquestion
                });
            });
            if(currentquestion<allQuestions.length){
                setupOptions();
                if(currentquestion==allQuestions.length-1){
                    $next.html("Envoyer");
                    $next.click(function(){
                        $questions.hide();
                        $result.html("Vous avez un score de " + correctAnswers + " questions correctes sur " + currentquestion + " questions ! ").hide();
                        $result.fadeIn(1500);
                    });

                }

            };
        });
    });
});