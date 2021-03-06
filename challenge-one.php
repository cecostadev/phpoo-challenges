<?php
/*
Challenge 1: Implement AnswerInterface and get Question to echo "4".
*/
class Question
{
    public function __construct(AnswerInterface $answer)
    {
        echo "What is 2 + 2?\n";
        $answer = $answer->get()->the()->answer();
        if ($answer instanceof AnswerInterface) {
            echo $answer . PHP_EOL;
        }
    }
}
interface AnswerInterface
{
    public function get();
    public function the();
    public function answer();
}
// start editing here
use AnswerQuestion as Answer;

class AnswerQuestion implements AnswerInterface
{
    private $value;

    public function __toString()
    {
        return "$this->value";
    }

    public function get()
    {   
        $this->value = 2;
        return $this;
    }

    public function the()
    {   
        $this->value +=2;
        return $this;
    }

    public function answer()
    {
        return $this;
    }

}
// end editing here
$answer = new Answer;
$question = new Question($answer);
