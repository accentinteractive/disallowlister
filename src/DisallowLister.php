<?php

namespace Accentinteractive;

class DisallowLister
{

    /**
     * @var array
     */
    protected $disallowList;

    public function __construct(array $disallowList = [])
    {
        $this->disallowList = $disallowList;
    }

    public function isDisallowed(string $string): bool
    {
        $string = explode(' ', $string);

        foreach ($string as $word) {
            if ($this->stringIsDisallowed($word)) {
                return true;
            }
        }

        return false;
    }

    public function addItem(string $string): void
    {
        $this->disallowList[] = $string;
    }

    public function removeItem(string $string): void
    {
        $this->disallowList = array_diff($this->disallowList, [$string]);
    }

    /**
     * @return array
     */
    public function getDisallowList(): array
    {
        return $this->disallowList;
    }

    /**
     * @param array $disallowList
     */
    public function setDisallowList(array $disallowList): void
    {
        $this->disallowList = $disallowList;
    }

    protected function stringIsDisallowed(string $string): bool
    {
        foreach ($this->disallowList as $search) {
            var_dump($search);
            var_dump($string);
            if (fnmatch($search, $string, FNM_CASEFOLD)) {
                return true;
            }
        }

        return false;
    }
}
