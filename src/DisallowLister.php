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

    protected $wordForWord = false;

    public function __construct(array $disallowList = [])
    {
        $this->disallowList = $disallowList;
    }

    public function isDisallowed(string $string): bool
    {
        if ($this->isCaseSensitive == false) {
            $string = strtolower($string);
        }

        if ($this->wordForWord == false) {
            return $this->stringIsDisallowed($string);
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

    public function add($item): DisallowLister
    {
        if ( ! is_string($item) && ! is_array($item)) {
            throw new DisallowListerException('$item must be a string or an array');
        }

        $item = (array) $item;
        $this->disallowList = array_merge($this->disallowList, $item);

        return $this;
    }

    public function remove($item): DisallowLister
    {
        $item = (array) $item;
        $this->disallowList = array_diff($this->disallowList, $item);

        return $this;
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
    public function setDisallowList(array $disallowList): DisallowLister
    {
        $this->disallowList = $disallowList;

        return $this;
    }

    /**
     * @param bool $wordForWord
     */
    public function setWordForWord(bool $wordForWord): DisallowLister
    {
        $this->wordForWord = (bool) $wordForWord;

        return $this;
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
