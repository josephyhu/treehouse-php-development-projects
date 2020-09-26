<?php
class Game
{
    private $phrase;
    private $lives = 5;
    private $top = ['q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p'];
    private $middle = ['a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l'];
    private $bottom = ['z', 'x', 'c', 'v', 'b', 'n', 'm'];

    public function __construct($phrase)
    {
        $this->phrase = $phrase;
    }

    public function rowKey($row)
    {
        $output .= "<div class='keyrow'>";
        foreach ($row as $letter) {
            $output .= $this->key($letter);
        }
        $output .= "</div>";
        return $output;
    }

    public function displayKeyboard()
    {
        $output = "";
        $output .= "<form method='post' action='play.php'>";
        $output .= "<div id='qwerty' class='section'>";
        $output .= $this->rowKey($this->top);
        $output .= $this->rowKey($this->middle);
        $output .= $this->rowKey($this->bottom);
        $output .= "</div>";
        $output .= "</form>";

        return $output;
    }

    public function key($letter)
    {
        if (!in_array($letter, $this->phrase->selected)) {
            return "<input id='" . $letter . "' type='submit' name='key' value='" . $letter . "' class='key'>";
        } else {
            if ($this->phrase->checkLetter($letter)) {
                return "<input id='" . $letter . "' type='submit' name='key' value='" . $letter . "' class='key correct' disabled>";
            } else {
                return "<input id='" . $letter . "' type='submit' name='key' value='" . $letter . "' class='key incorrect' disabled>";
            }
        }
    }

    public function displayScore()
    {
        $output = "";
        $output .= "<div id='scoreboard' class='section'>";
        $output .= "<ol>";
        for ($i = 1; $i <= $this->lives - $this->phrase->numberLost(); $i++) {
            $output .= "<li class='tries'><img src='images/liveHeart.png' height='35px' width='30px'></li>";
        }
        for ($i = 1; $i <= $this->phrase->numberLost(); $i++) {
            $output .= "<li class='tries'><img src='images/lostHeart.png' height='35px' width='30px'</li>";
        }
        $output .= "</ol>";
        $output .= "</div>";

        return $output;
    }

    public function checkForLose()
    {
        if ($this->phrase->numberLost() >= $this->lives) {
            return true;
        } else {
            return false;
        }
    }

    public function checkForWin()
    {
        if (count(array_intersect($this->phrase->selected, $this->phrase->getLetterArray())) == count($this->phrase->getLetterArray())) {
            return true;
        } else {
            return false;
        }
    }

    public function gameOver()
    {
        if ($this->checkForLose() == true) {
            echo "<div id='overlay' class='main-container lose'>";
            echo "<h1>The phrase was: '" . $this->phrase->currentPhrase . "'. Better luck next time!</h1>";
            echo "<form action='play.php' method='post'>";
            echo "<input name='start' id='btn__reset' type='submit' value='Restart Game' />";
            echo "</form>";
        } elseif ($this->checkForWin() == true) {
            echo "<div id='overlay' class='main-container win'>";
            echo "<h1>Congratulations on guessing: '" . $this->phrase->currentPhrase . "'</h1>";
            echo "<form action='play.php' method='post'>";
            echo "<input name='start' id='btn__reset' type='submit' value='Restart Game' />";
            echo "</form>";
        } else {
            echo "<div class='main-container' id='overlay'>";
        }
    }
}
