<?php

class User
{
    private string $username = "";
    private int $age;
    private string $sex = "";
    private string $password = "";
    private string $email = "";

    public function __construct(string $username, int $age, string $sex, string $password, string $email)
    {
        $this->username = $username;
        $this->age = $age;
        $this->sex = $sex;
        $this->password = $password;
        $this->email = $email;
    }


    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    public function getSex(): string
    {
        return $this->sex;
    }

    public function setSex(string $sex): void
    {
        $this->sex = $sex;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    public function __toString(): string
    {
        return $this->username . $this->age ." éves, neme: ". $this->sex . ", e-mail cím: " . $this->email;
    }

}
