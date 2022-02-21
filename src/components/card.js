/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

export default function Card({ title, description, author }) {
	return (
		<div className="book-card">
			<h2>{title}</h2>
			<p>{description}</p>
			<span>
				{__("Written By:", "bbuilds-nyt-block")} {author}
			</span>
		</div>
	);
}
