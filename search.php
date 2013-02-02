<?php get_header(); ?>

	<?php if (have_posts()) : ?>

		<h2>Search Results</h2>

		<?php while (have_posts()) : the_post(); ?>

			<article <?php post_class() ?> id="post-<?php the_ID(); ?>">

				<h2><?php the_title(); ?></h2>

				<?php the_excerpt(); ?>

			</article>

		<?php endwhile; ?>

	<?php else : ?>

		<h2>No posts found.</h2>

	<?php endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
