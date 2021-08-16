<?php

namespace Accentinteractive;

class DisallowLister
{

    /**
     * @var array
     */
    protected $disallowList = [];

    /**
     * @var bool
     */
    protected $isCaseSensitive = false;

    public function __construct(array $disallowList = [])
    {
        $this->disallowList = $disallowList;
    }

    public function isDisallowed(string $string): bool
    {
        if ($this->isCaseSensitive == false) {
            $string = strtolower($string);
        }

        $string = explode(' ', $string);

        foreach ($string as $word) {
            if ($this->stringIsDisallowed($word)) {
                return true;
            }
        }

        return false;
    }

    public function caseSensitive(bool $isCaseSensitive = false)
    {
        $this->isCaseSensitive = $isCaseSensitive;

        return $this;
    }

    public function addItem(string $string): DisallowLister
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
            if ($this->isCaseSensitive == false) {
                $string = strtolower($string);
            }

            if (fnmatch($search, $string)) {
                return true;
            }
        }

        return false;
    }
}
