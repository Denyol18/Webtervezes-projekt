<?php

class Comment
{
    private $author;
    private $date;
    private $text;


    public function __construct($author, $date, $text) {
        $this->author = $author;
        $this->date = $date;
        $this->text = $text;
    }


    public function getAuthor()
    {
        return $this->author;
    }


    public function setAuthor($author): void
    {
        $this->author = $author;
    }


    public function getDate()
    {
        return $this->date;
    }


    public function setDate($date): void
    {
        $this->date = $date;
    }


    public function getText()
    {
        return $this->text;
    }


    public function setText($text): void
    {
        $this->text = $text;
    }


}

