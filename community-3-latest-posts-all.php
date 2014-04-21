<?
include_once(G5_LIB_PATH.'/thumbnail.lib.php'); 

widget_css();


if( $widget_config['title'] ) $title = $widget_config['title'];
else $title = 'Latest Posts';

if( $widget_config['no'] ) $limit = $widget_config['no'];
else $limit = 3;

$posts = g::posts(
	array(
		'domain'			=> etc::domain(),
		'wr_option'			=> array( "NOT LIKE '%secret%'" ),
		'limit'				=> $limit,
	)
);
?>
<div class="com3-latest-posts" >
		<div class='title'>
			<table width='100%'>
				<tr valign='top'>
					<td align='left' class='title-left'>
						<img src="<?=x::url_theme()?>/img/3line.png">
						<span class='label'><?=$title?></span>
					</td>
				</tr>
			</table>
		</div>

	<div class='com3-latest-posts-items'>
		<table width='100%' cellpadding=0 cellspacing=0>
		<?php
			if ( $posts ) {
			$i = 1;
			$ctr = count($posts);
			foreach ( $posts as $p ) {
				$latest_subject = conv_subject($p['wr_subject'],15, '...' );
	
				$latest_url = url_forum_read( $p['bo_table'], $p['wr_id'] );
				
				
				$latest_comment_count = '['.strip_tags($p['wr_comment']).']';
				if ( $latest_comment_count == 0 ) $no_comment = 'no-comment';
				else $no_comment = '';
				
				$latest_img = x::post_thumbnail( $p['bo_table'] , $p['wr_id'], 38, 38);
				$img = $latest_img['src'];
				if ( empty($img) ) {
					$_wr_content = db::result("SELECT wr_content FROM $g5[write_prefix]$p[bo_table] WHERE wr_id='$p[wr_id]'");
					$img = x::thumbnail_from_image_tag($_wr_content, $p['bo_table'], 38, 38);
					if ( empty($img) ) $img = x::url_theme().'/img/no-image.png';
				}
				if( $i == $ctr ) $last_post = "class='last-item'";
				else $last_post = '';
	
		?>	
				<tr <?=$last_post?> valign='top'>
					<td width='40'>
						<div class='post-image'><a href='<?=$img?>' target='_blank'><img src='<?=$img?>'></a></div>
					</td>
					<td width='110'>
						<div class='subject'><a href='<?=$latest_url?>'><?=$latest_subject?></a></div>
					</td>
					<td width='40' align='right'>
						<span class='num_comments'><?=$latest_comment_count?></span>
					</td>
				</tr>
		<? $i++; 
			}
		}
		else echo "<tr valign='top'><td>최신글이 없습니다.</td></tr>";
	?>
		</table>
	</div>
</div> <!--posts--recent-->
