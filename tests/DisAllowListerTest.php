<?php

namespace Tests;

use Accentinteractive\DisallowLister;
use Accentinteractive\DisallowListerException;
use PHPUnit\Framework\TestCase;
use StdClass;

class DisAllowListerTest extends TestCase
{

    /** @test */
    public function it_can_pass_a_disallowlist_in_the_constructor()
    {
        $disallowLister = new DisallowLister(['foo']);
        $this->assertEquals(['foo'], $disallowLister->getDisallowList());
    }

    /** @test */
    public function it_can_set_a_disallowlist()
    {
        $disallowLister = (new DisallowLister())->setDisallowList(['bar']);
        $this->assertEquals(['bar'], $disallowLister->getDisallowList());
    }

    /** @test */
    public function it_can_add_a_string_to_the_disallowlist()
    {
        $disallowLister = (new DisallowLister(['bar']))->add('foo');
        $this->assertEquals(['bar', 'foo'], $disallowLister->getDisallowList());
    }

    /** @test */
    public function it_can_add_an_array_to_the_disallowlist()
    {
        $disallowLister = (new DisallowLister(['bar']))->add(['foo', 'bat']);
        $this->assertEquals(['bar', 'foo', 'bat'], $disallowLister->getDisallowList());
    }

    /** @test */
    public function it_throws_an_exception_if_item_is_of_wrong_type()
    {
        $this->expectException(DisallowListerException::class);
        (new DisallowLister())->add(new StdClass);

        (new DisallowLister())->remove(new StdClass);
    }

    /** @test */
    public function it_can_remove_a_string_from_the_disallowlist()
    {
        $disallowLister = (new DisallowLister(['foo', 'bar']))->remove('bar');
        $this->assertEquals(['foo'], $disallowLister->getDisallowList());
    }

    /** @test */
    public function it_can_remove_an_array_from_the_disallowlist()
    {
        $disallowLister = (new DisallowLister(['foo', 'bar']))->remove(['foo', 'bar']);
        $this->assertEquals([], $disallowLister->getDisallowList());
    }

    /** @test */
    public function it_disallows_a_string_that_is_in_the_disallow_list()
    {
        $disallowLister = new DisallowLister(['foo@bar.com']);

        $this->assertSame(true, $disallowLister->isDisallowed('foo@bar.com'));
    }

    /** @test */
    public function it_does_not_disallow_a_string_that_is_not_in_the_disallow_list()
    {
        $disallowLister = new DisallowLister(['foo@bar.com']);

        $this->assertSame(false, $disallowLister->isDisallowed('baz@bat.com'));
    }

    public function it_matches_words()
    {
        $disallowLister = new DisallowLister(['sexuologist']);
        $this->assertTrue($disallowLister->isDisallowed('John is bisexual'));
    }

    public function it_matches_only_whole_words()
    {
        $disallowLister = new DisallowLister(['sex']);
        $this->assertFalse($disallowLister->isDisallowed('John is bisexual'));
    }

    /** @test */
    public function it_can_match_wildcards()
    {
        $disallowLister = new DisallowLister(['*sex*']);
        $this->assertTrue($disallowLister->isDisallowed('John is bisexual'));

        $disallowLister = new DisallowLister(['sex*']);
        $this->assertFalse($disallowLister->isDisallowed('John is bisexual'));

        $disallowLister = new DisallowLister(['*sex']);
        $this->assertFalse($disallowLister->isDisallowed('John is bisexual'));
    }

    /** @test */
    public function it_can_match_question_mark_wildcards()
    {
        $disallowLister = new DisallowLister(['m?n']);
        $this->assertTrue($disallowLister->isDisallowed('man'));
        $this->assertFalse($disallowLister->isDisallowed('moon'));
    }

    /** @test */
    public function it_can_match_bracket_wildcards()
    {
        $disallowLister = new DisallowLister(['m[o,u]m']);
        $this->assertTrue($disallowLister->isDisallowed('mom'));
        $this->assertTrue($disallowLister->isDisallowed('mum'));
        $this->assertFalse($disallowLister->isDisallowed('mam'));
    }

    /** @test */
    public function it_can_be_case_sensitive()
    {
        $disallowLister = (new DisallowLister(['mom']))->caseSensitive(true);
        $this->assertFalse($disallowLister->isDisallowed('MOM'));

        $disallowLister->caseSensitive(false);
        $this->assertTrue($disallowLister->isDisallowed('MOM'));
    }

}
