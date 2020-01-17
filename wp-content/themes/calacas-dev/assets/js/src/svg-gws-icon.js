/**
 * Set an SVG icon for the GWS Block category.
 */

const el = wp.element.createElement;
const SVG = wp.components.SVG;
const circle = el( 'circle', {
	cx: 12,
	cy: 12,
	r: 12,
	fill: '#22222e',
} );
const path1 = el( 'path', {
	d: 'M0,0H0V0ZM0,0ZM0,0Z',
	fill: '#00d7c8',
} );
const path2 = el( 'path', {
	d: 'M0,0ZM0,0H0V9c0-9,4-9,0,1H0V0H0V9H10C0,0,0,0,0,9V0ZM0,0V0ZM0,0Z',
	fill: '#fff',
} );

const gwsSvgIcon = el(
	SVG,
	{ width: 24, height: 24, viewBox: '0 0 24 24' },
	circle,
	path1,
	path2
);
wp.blocks.updateCategory( 'calacas-blocks', { icon: gwsSvgIcon } );
