/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#useBlockProps
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#inspectorcontrols
 */
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";

/**
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-api-fetch/
 */

import apiFetch from "@wordpress/api-fetch";

/**
 * @see https://reactjs.org/docs/hooks-reference.html#useeffect
 */
import { useEffect } from "@wordpress/element";

/**
 * @see https://developer.wordpress.org/block-editor/reference-guides/components/spinner/
 * @see https://developer.wordpress.org/block-editor/reference-guides/components/panel/
 * @see https://developer.wordpress.org/block-editor/reference-guides/components/range-control/
 */

import { Spinner, PanelBody, RangeControl } from "@wordpress/components";

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import "./editor.scss";

const END_POINT = "forumone/v1/nyt";

//Grabbing info form rest API
async function fetchAndSetResponse(setAttributes) {
	try {
		const response = await apiFetch({ path: END_POINT });
		setAttributes({
			apiData: response,
		});
	} catch (e) {
		console.error("Oh no, there is an error!", { error: e });
		setAttributes({ apiData: {}, resultsList: [] });
	}
}

//setting up results to display based off number slection
function setUpResults(apiData, setAttributes, numberOfPosts) {
	const list = [];
	if (apiData.results) {
		for (let i = 0; i < numberOfPosts; i++) {
			list.push(apiData.results[i]);
		}
		setAttributes({
			resultsList: list,
			isLoading: false,
		});
	}
}

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
	const { apiData, isLoading, resultsList, numberOfPosts } = attributes;

	useEffect(() => {
		fetchAndSetResponse(setAttributes);
	}, []);

	useEffect(() => {
		setUpResults(apiData, setAttributes, numberOfPosts);
	}, [apiData, numberOfPosts]);

	function onChangeNumberOfPosts(val) {
		setAttributes({
			numberOfPosts: val,
		});
	}

	return (
		<p {...useBlockProps()}>
			{__("Forumone Test – hello from the editor!", "forumone-test")}
		</p>
	);
}
