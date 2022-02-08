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
 */
import { useBlockProps } from "@wordpress/block-editor";

//Custom Book Card Component
import BookCard from "./components/Card";

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#save
 *
 * @return {WPElement} Element to render.
 */
export default function save({ attributes }) {
	const { resultsList } = attributes;

	return (
		<div {...useBlockProps.save()}>
			<ul className="results">
				{resultsList &&
					resultsList.map((item, index) => {
						return (
							<li key={index}>
								<BookCard
									title={item?.book_details[0]?.title}
									description={item?.book_details[0]?.description}
									author={item?.book_details[0]?.author}
								/>
							</li>
						);
					})}
			</ul>
		</div>
	);
}
