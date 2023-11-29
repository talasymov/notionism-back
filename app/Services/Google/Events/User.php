<?php

namespace App\Services\Google\Events;

class User
{
    /**
     * @param string $email
     * @param string|null $displayName
     * @param bool|null $self
     */
    public function __construct(
        public string $email,
        public string|null $displayName,
        public bool|null $self
    ) {
    }

    public function toArray(): array
    {
        $data = [
            'email' => $this->email,
        ];

        if ($this->displayName) {
            $data['displayName'] = $this->displayName;
        }

        if ($this->self) {
            $data['self'] = true;
        }

        return $data;
    }
}
