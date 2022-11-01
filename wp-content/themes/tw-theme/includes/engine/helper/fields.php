<?php

// Exit if accessed directly.
defined('ABSPATH') || exit();

function twtheme_slider_config_fields()
{
	return [
		[
			'id' => 'interval',
			'name' => '[interval]',
			'type' => 'text',
			'label' => 'interval',
			'value' => '5000',
			'description' => 'Intervall Laufzeit in ms',
		],
		[
			'id' => 'speed',
			'name' => '[speed]',
			'type' => 'text',
			'label' => 'speed',
			'value' => '400',
			'description' => 'Übergangsgeschwindigkeit des Slides in ms',
		],
		[
			'id' => 'mediaQuery',
			'name' => '[mediaQuery]',
			'type' => 'text',
			'label' => 'mediaQuery',
			'value' => 'min',
			'description' => 'media Query Richting (min|max)',
		],
		[
			'id' => 'noDrag',
			'name' => '[noDrag]',
			'type' => 'text',
			'label' => 'noDrag',
			'value' => 'a, button, input, textarea, .no-drag',
			'description' => 'Elemente die ein "ziehen" unterbinden (Mit Komma getrennt)',
		],
		[
			'id' => 'arrowPath',
			'name' => '[arrowPath]',
			'type' => 'text',
			'label' => 'arrowPath',
			'description' => 'Ändert den Pfeil SVG Pfad. Die Größe muss 40x40 sein!',
		],
		[
			'type' => 'headline',
			'label' => 'Breakpoint (Mobile)',
		],
		[
			'id' => 'type',
			'name' => '[type]',
			'type' => 'select',
			'label' => 'type',
			'description' => 'Carousel Typ',
			'options' => [
				[
					'value' => 'slide',
					'label' => 'Slide',
					'checked' => 'true',
				],
				[
					'value' => 'loop',
					'label' => 'Loop',
				],
				[
					'value' => 'fade',
					'label' => 'Fade',
				],
			],
		],
		[
			'id' => 'perPage',
			'name' => '[perPage]',
			'type' => 'number',
			'label' => 'perPage',
			'value' => '4',
			'data-filter' => 'stringtonumber',
			'description' => 'Anzahl Slides im sichtbaren Bereich',
		],
		[
			'id' => 'perMove',
			'name' => '[perMove]',
			'type' => 'number',
			'label' => 'perMove',
			'value' => '1',
			'data-filter' => 'stringtonumber',
			'description' => 'Anzahl der Slides in Bewegung',
		],
		[
			'id' => 'arrows',
			'name' => '[arrows]',
			'type' => 'select',
			'label' => 'arrows',
			'description' => 'Pfeile darstellen',
			'options' => [
				[
					'value' => 'false',
					'label' => 'Nein',
					'checked' => 'true',
				],
				[
					'value' => 'true',
					'label' => 'Ja',
				],
			],
		],
		[
			'id' => 'pagination',
			'name' => '[pagination]',
			'type' => 'select',
			'label' => 'pagination',
			'description' => 'Pagniation darstellen',
			'options' => [
				[
					'value' => 'false',
					'label' => 'Nein',
				],
				[
					'value' => 'true',
					'label' => 'Ja',
					'checked' => 'true',
				],
			],
		],
		[
			'id' => 'drag',
			'name' => '[drag]',
			'type' => 'select',
			'label' => 'drag',
			'description' => 'Carousel ziehen mit der Maus aktivieren',
			'options' => [
				[
					'value' => 'false',
					'label' => 'Nein',
					'checked' => 'true',
				],
				[
					'value' => 'true',
					'label' => 'Ja',
				],
				[
					'value' => 'free',
					'label' => 'Free',
				],
			],
		],
		[
			'id' => 'autoplay',
			'name' => '[autoplay]',
			'type' => 'select',
			'label' => 'autoplay',
			'description' => 'Automatisches rotieren',
			'options' => [
				[
					'value' => 'false',
					'label' => 'Nein',
					'checked' => 'true',
				],
				[
					'value' => 'true',
					'label' => 'Ja',
				],
			],
		],
		[
			'id' => 'padding',
			'name' => '[padding]',
			'type' => 'text',
			'label' => 'padding',
			'description' => 'Setzt einen Abstand link und rechts vom Slider (CSS Format)',
		],
		[
			'type' => 'headline',
			'label' => 'Breakpoint SM (Small Tablet)',
		],
		[
			'id' => 'breakpoints-576-type',
			'name' => '[breakpoints][576][type]',
			'type' => 'select',
			'label' => 'type',
			'description' => 'Carousel Typ',
			'options' => [
				[
					'value' => 'slide',
					'label' => 'Slide',
					'checked' => 'true',
				],
				[
					'value' => 'loop',
					'label' => 'Loop',
				],
				[
					'value' => 'fade',
					'label' => 'Fade',
				],
			],
		],
		[
			'id' => 'breakpoints-576-perPage',
			'name' => '[breakpoints][576][perPage]',
			'type' => 'number',
			'label' => 'perPage',
			'value' => '4',
			'data-filter' => 'stringtonumber',
			'description' => 'Anzahl Slides im sichtbaren Bereich',
		],
		[
			'id' => 'breakpoints-576-perMove',
			'name' => '[breakpoints][576][perMove]',
			'type' => 'number',
			'label' => 'perMove',
			'value' => '1',
			'data-filter' => 'stringtonumber',
			'description' => 'Anzahl der Slides in Bewegung',
		],
		[
			'id' => 'breakpoints-576-arrows',
			'name' => '[breakpoints][576][arrows]',
			'type' => 'select',
			'label' => 'arrows',
			'description' => 'Pfeile darstellen',
			'options' => [
				[
					'value' => 'false',
					'label' => 'Nein',
					'checked' => 'true',
				],
				[
					'value' => 'true',
					'label' => 'Ja',
				],
			],
		],
		[
			'id' => 'breakpoints-576-pagination',
			'name' => '[breakpoints][576][pagination]',
			'type' => 'select',
			'label' => 'pagination',
			'description' => 'Pagniation darstellen',
			'options' => [
				[
					'value' => 'false',
					'label' => 'Nein',
				],
				[
					'value' => 'true',
					'label' => 'Ja',
					'checked' => 'true',
				],
			],
		],
		[
			'id' => 'breakpoints-576-drag',
			'name' => '[breakpoints][576][drag]',
			'type' => 'select',
			'label' => 'drag',
			'description' => 'Carousel ziehen mit der Maus aktivieren',
			'options' => [
				[
					'value' => 'false',
					'label' => 'Nein',
					'checked' => 'true',
				],
				[
					'value' => 'true',
					'label' => 'Ja',
				],
				[
					'value' => 'free',
					'label' => 'Free',
				],
			],
		],
		[
			'id' => 'breakpoints-576-autoplay',
			'name' => '[breakpoints][576][autoplay]',
			'type' => 'select',
			'label' => 'autoplay',
			'description' => 'Automatisches rotieren',
			'options' => [
				[
					'value' => 'false',
					'label' => 'Nein',
					'checked' => 'true',
				],
				[
					'value' => 'true',
					'label' => 'Ja',
				],
			],
		],
		[
			'id' => 'breakpoints-576-padding',
			'name' => '[breakpoints][576][padding]',
			'type' => 'text',
			'label' => 'padding',
			'description' => 'Setzt einen Abstand link und rechts vom Slider (CSS Format)',
		],
		[
			'type' => 'headline',
			'label' => 'Breakpoint MD (Tablet)',
		],
		[
			'id' => 'breakpoints-768-type',
			'name' => '[breakpoints][768][type]',
			'type' => 'select',
			'label' => 'type',
			'description' => 'Carousel Typ',
			'options' => [
				[
					'value' => 'slide',
					'label' => 'Slide',
					'checked' => 'true',
				],
				[
					'value' => 'loop',
					'label' => 'Loop',
				],
				[
					'value' => 'fade',
					'label' => 'Fade',
				],
			],
		],
		[
			'id' => 'breakpoints-768-perPage',
			'name' => '[breakpoints][768][perPage]',
			'type' => 'number',
			'label' => 'perPage',
			'value' => '4',
			'data-filter' => 'stringtonumber',
			'description' => 'Anzahl Slides im sichtbaren Bereich',
		],
		[
			'id' => 'breakpoints-768-perMove',
			'name' => '[breakpoints][768][perMove]',
			'type' => 'number',
			'label' => 'perMove',
			'value' => '1',
			'data-filter' => 'stringtonumber',
			'description' => 'Anzahl der Slides in Bewegung',
		],
		[
			'id' => 'breakpoints-768-arrows',
			'name' => '[breakpoints][768][arrows]',
			'type' => 'select',
			'label' => 'arrows',
			'description' => 'Pfeile darstellen',
			'options' => [
				[
					'value' => 'false',
					'label' => 'Nein',
					'checked' => 'true',
				],
				[
					'value' => 'true',
					'label' => 'Ja',
				],
			],
		],
		[
			'id' => 'breakpoints-768-pagination',
			'name' => '[breakpoints][768][pagination]',
			'type' => 'select',
			'label' => 'pagination',
			'description' => 'Pagniation darstellen',
			'options' => [
				[
					'value' => 'false',
					'label' => 'Nein',
				],
				[
					'value' => 'true',
					'label' => 'Ja',
					'checked' => 'true',
				],
			],
		],
		[
			'id' => 'breakpoints-768-drag',
			'name' => '[breakpoints][768][drag]',
			'type' => 'select',
			'label' => 'drag',
			'description' => 'Carousel ziehen mit der Maus aktivieren',
			'options' => [
				[
					'value' => 'false',
					'label' => 'Nein',
					'checked' => 'true',
				],
				[
					'value' => 'true',
					'label' => 'Ja',
				],
				[
					'value' => 'free',
					'label' => 'Free',
				],
			],
		],
		[
			'id' => 'breakpoints-768-autoplay',
			'name' => '[breakpoints][768][autoplay]',
			'type' => 'select',
			'label' => 'autoplay',
			'description' => 'Automatisches rotieren',
			'options' => [
				[
					'value' => 'false',
					'label' => 'Nein',
					'checked' => 'true',
				],
				[
					'value' => 'true',
					'label' => 'Ja',
				],
			],
		],
		[
			'id' => 'breakpoints-768-padding',
			'name' => '[breakpoints][768][padding]',
			'type' => 'text',
			'label' => 'padding',
			'description' => 'Setzt einen Abstand link und rechts vom Slider (CSS Format)',
		],
		[
			'type' => 'headline',
			'label' => 'Breakpoint LG (Desktop)',
		],
		[
			'id' => 'breakpoints-992-type',
			'name' => '[breakpoints][992][type]',
			'type' => 'select',
			'label' => 'type',
			'description' => 'Carousel Typ',
			'options' => [
				[
					'value' => 'slide',
					'label' => 'Slide',
					'checked' => 'true',
				],
				[
					'value' => 'loop',
					'label' => 'Loop',
				],
				[
					'value' => 'fade',
					'label' => 'Fade',
				],
			],
		],
		[
			'id' => 'breakpoints-992-perPage',
			'name' => '[breakpoints][992][perPage]',
			'type' => 'number',
			'label' => 'perPage',
			'value' => '4',
			'data-filter' => 'stringtonumber',
			'description' => 'Anzahl Slides im sichtbaren Bereich',
		],
		[
			'id' => 'breakpoints-992-perMove',
			'name' => '[breakpoints][992][perMove]',
			'type' => 'number',
			'label' => 'perMove',
			'value' => '1',
			'data-filter' => 'stringtonumber',
			'description' => 'Anzahl der Slides in Bewegung',
		],
		[
			'id' => 'breakpoints-992-arrows',
			'name' => '[breakpoints][992][arrows]',
			'type' => 'select',
			'label' => 'arrows',
			'description' => 'Pfeile darstellen',
			'options' => [
				[
					'value' => 'false',
					'label' => 'Nein',
					'checked' => 'true',
				],
				[
					'value' => 'true',
					'label' => 'Ja',
				],
			],
		],
		[
			'id' => 'breakpoints-992-pagination',
			'name' => '[breakpoints][992][pagination]',
			'type' => 'select',
			'label' => 'pagination',
			'description' => 'Pagniation darstellen',
			'options' => [
				[
					'value' => 'false',
					'label' => 'Nein',
				],
				[
					'value' => 'true',
					'label' => 'Ja',
					'checked' => 'true',
				],
			],
		],
		[
			'id' => 'breakpoints-992-drag',
			'name' => '[breakpoints][992][drag]',
			'type' => 'select',
			'label' => 'drag',
			'description' => 'Carousel ziehen mit der Maus aktivieren',
			'options' => [
				[
					'value' => 'false',
					'label' => 'Nein',
					'checked' => 'true',
				],
				[
					'value' => 'true',
					'label' => 'Ja',
				],
				[
					'value' => 'free',
					'label' => 'Free',
				],
			],
		],
		[
			'id' => 'breakpoints-992-autoplay',
			'name' => '[breakpoints][992][autoplay]',
			'type' => 'select',
			'label' => 'autoplay',
			'description' => 'Automatisches rotieren',
			'options' => [
				[
					'value' => 'false',
					'label' => 'Nein',
					'checked' => 'true',
				],
				[
					'value' => 'true',
					'label' => 'Ja',
				],
			],
		],
		[
			'id' => 'breakpoints-992-padding',
			'name' => '[breakpoints][992][padding]',
			'type' => 'text',
			'label' => 'padding',
			'description' => 'Setzt einen Abstand link und rechts vom Slider (CSS Format)',
		],
	];
}
