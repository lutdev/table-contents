<?php

declare(strict_types=1);

namespace Lutdev\TOC\Tests\BaseTest;

use Lutdev\TOC\TableContents;
use PHPUnit\Framework\TestCase;

class TableContentsTest extends TestCase
{
	private TableContents $toc;

	private string $text = '';

	public function setUp(): void
	{
		$this->toc = new TableContents();
        $this->text =
            '<h1>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.</h1>' .
            'Proin eget tortor risus. Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. ' .
            '<h2>Quisque velit nisi, pretium ut lacinia in, elementum id enim.</h2> Donec sollicitudin molestie malesuada. ' .
            'Curabitur aliquet quam id dui posuere blandit. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. ' .
            '<h3>Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.</h3> Lorem ipsum dolor sit amet, consectetur ' .
            'adipiscing elit. Nulla quis lorem ut libero malesuada feugiat.';
	}

	public function testHeaderLinks(): void
	{
		$newDescription = $this->toc->headerLinks($this->text);

		self::assertEquals(
            "<h1 id='vestibulum-ac-diam-sit-amet-quam-vehicula-elementum-sed-sit-amet-dui'>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.</h1>Proin eget tortor risus. Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. <h2 id='quisque-velit-nisi-pretium-ut-lacinia-in-elementum-id-enim'>Quisque velit nisi, pretium ut lacinia in, elementum id enim.</h2> Donec sollicitudin molestie malesuada. Curabitur aliquet quam id dui posuere blandit. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. <h3 id='mauris-blandit-aliquet-elit-eget-tincidunt-nibh-pulvinar-a'>Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.</h3> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla quis lorem ut libero malesuada feugiat.",
            $newDescription
        );
	}
}
