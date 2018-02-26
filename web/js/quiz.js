$( document ).ready(function() {
    function QuizQuestion(image, question, choices, correctAnswer) {
        this.image = image;
        this.question = question;
        this.choices = choices;
        this.correctAnswer = correctAnswer;
    }

    var allQuestions = [
        new QuizQuestion("/img/quiz/quiz-1.png", "Quel est cet oiseau ?",["Une mésange", "Une musulette a poil bleu", "Un herboris", "Une hirondelle des près"],0),
        new QuizQuestion("/img/quiz/quiz-2.jpg", "Dans quelle région a t-on le plus de chance d’apercevoir cet oiseau ?",["Dans le Jura", "Dans les Pyrénées", "Dans les Hauts de France", "En région parisienne"],1),
        new QuizQuestion("/img/quiz/quiz-3.jpg", "Combien d'espèce de moineau peut on observer en France ?",["3", "7", "12", "15"],1),
        new QuizQuestion("/img/quiz/quiz-4.jpg", "Dans quelle famille d’oiseau le rouge Gorge se place t-il ?",["Turdidae", "Accipitridé", "Alcidé", "Alcédinidé"],0),
        new QuizQuestion("/img/quiz/quiz-5.jpg", "Quel est le nom de cet oiseau chanteur ?",["Le rossignol", "Le merle", "Le chardonnet", "Le canari"],2),
        new QuizQuestion("/img/quiz/quiz-6.jpg", "Quel est le nom de cet oiseau ?",["La mouette epére", "Le rossignol des chants", "Le moineau d’eau douce", "La musilette des Près"],1),
        new QuizQuestion("/img/quiz/quiz-7.jpg", "Quel est le nom de cet élégant spécimen ?",["Panure à moustaches", "Perruche ondulée", "Pic vert", "Martin-pêcheur d’Europe"],0),
        new QuizQuestion("/img/quiz/quiz-8.jpg", "Pourquoi les Martin pecheur sont-ils difficiles à observer ?",["Ils sont rares", "Ils dorment souvent", "Ils sont en voie de disparition", "Ils se camoulflent grace à leur plumage"],3),
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
        $('.quiz-image').html('<img src="'+ allQuestions[currentquestion].image +'" class="img-responsive"/>');
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

        $next.click(function() {
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
                if(currentquestion == allQuestions.length-1){
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