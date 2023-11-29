<?php

namespace App\Services\Google\Events;

class Attendee
{
    public function __construct(
        public string $email,
        public bool|null $self = null,
        public bool|null $organizer = null,
        public string|null $responseStatus = null
    ) {
        $this->email = str($this->email)->trim();
    }

    public function toArray(): array
    {
        $data = [
            'email' => $this->email,
        ];

        if ($this->self) {
            $data['self'] = true;
        }

        if ($this->organizer) {
            $data['self'] = true;
        }

        if ($this->responseStatus) {
            $data['responseStatus'] = $this->responseStatus;
        }

        return $data;
    }
}
