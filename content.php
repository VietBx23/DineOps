<?php
/**
 * Posts content single - Ultra Minimalist Luxury carreers (Final Optimized)
 */
$is_recru = has_term('carreers', 'category');
$current_id = get_the_ID();
$data = [
    'loc' => get_field('location'),
    'sal' => get_field('salary'),
    'exp' => get_field('experience'),
    'pos' => get_field('positions'),
    'expiry' => get_field('expirydate'),
];

$job_expired = ($data['expiry'] && strtotime($data['expiry']) < strtotime(date('Y-m-d')));
?>

<?php if ($is_recru) : ?>
    
    
    <style>
        :root {
            --primary-text: #1a1a1a;
            --secondary-text: #666;
            --border-gray: #e0e0e0;
            --bg-white: #ffffff;
            --page-padding-left: 5%; 
        }

        /* 1. LAYOUT RESET */
        .entry-header, .post-sidebar, #reviews, #comments, .comments-area { display: none !important; }
        .large-9.col, .col.large-9 { max-width: 100% !important; width: 100% !important; flex-basis: 100% !important; float: none !important; margin: 0 auto !important; padding: 0 !important; border: 0 !important; }

        .recru-master { 
            background: var(--bg-white) !important; 
            padding: 40px 0 100px; 
            font-family: 'Inter', sans-serif; 
            color: var(--primary-text);
            overflow-x: hidden;
        }

        /* 2. BREADCRUMB & HERO */
        .recru-breadcrumb {
            font-size: 14px;
            color: #999;
            padding: 0 var(--page-padding-left) 15px;
            margin-bottom: 25px;
        }
        .recru-breadcrumb strong { color: var(--primary-text); font-weight: 500; }
        .recru-breadcrumb a { text-decoration: none; color: inherit; }

        .recru-hero {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding: 0 var(--page-padding-left);
            margin-bottom: 40px;
        }

        .recru-hero-left { flex: 1; }

        .job-title {
            font-size: 72px;
            font-weight: 600;
            letter-spacing: -3.5px;
            line-height: 0.95;
            margin: 0 0 20px;
            color: var(--primary-text);
        }

        .job-meta {
            display: flex;
            align-items: center;
            gap: 18px;
            color: var(--secondary-text);
            font-size: 18px;
            font-weight: 400;
            flex-wrap: nowrap;
        }

        .job-meta span {
            white-space: nowrap;
        }

        .meta-dot {
            width: 6px;
            height: 6px;
            background-color: #333;
            border-radius: 50%;
            opacity: 0.8;
        }

        /* Action Button */
        .apply-btn-minimal {
            background-color: #333;
            color: white !important;
            text-decoration: none !important;
            padding: 14px 28px;
            border-radius: 40px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
        }

        .apply-btn-minimal:hover {
            background-color: #000;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .apply-btn-minimal--disabled {
            background-color: #999;
            color: rgba(255,255,255,0.9) !important;
            cursor: not-allowed;
            opacity: 0.7;
            pointer-events: none;
        }

        .apply-btn-minimal--disabled:hover {
            background-color: #999;
            transform: none;
            box-shadow: none;
        }

        /* 3. FULL WIDTH DIVIDER */
        .full-width-divider {
            width: 100vw;
            position: relative;
            left: 50%;
            right: 50%;
            margin-left: -50vw;
            margin-right: -50vw;
            border: 0;
            border-top: 1px solid var(--border-gray);
            margin-top: 0;
            margin-bottom: 50px;
        }

        /* 4. CONTENT SECTION */
        .job-content-wrap {
            padding: 0 var(--page-padding-left);
            max-width: 1000px; 
            margin-bottom: 80px;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 26px;
            font-weight: 600;
            margin-bottom: 45px;
            color: var(--primary-text);
        }

        .black-circle-icon {
            width: 20px;
            height: 20px;
            background-color: #333;
            border-radius: 50%;
        }

        .job-details-content {
            line-height: 1.8;
            font-size: 16px;
            color: var(--primary-text);
        }

        .job-details-content h3 {
            font-size: 15px;
            font-weight: 500;
            color: #888;
            margin: 35px 0 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .job-details-content ul {
            list-style: none;
            padding-left: 0;
            margin-bottom: 30px;
        }

        .job-details-content ul li {
            position: relative;
            padding-left: 20px;
            margin-bottom: 10px;
        }

        .job-details-content ul li::before {
            content: "•";
            position: absolute;
            left: 0;
            color: #000;
        }

        /* 5. RELATED SECTION (Integrated Style) */
        .related-minimal {
            margin-top: 100px;
            padding: 0 var(--page-padding-left);
        }

        .related-minimal-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 40px;
            text-align: center;
        }

        .related-minimal-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 24px;
        }

        .related-minimal-item {
            background: #111111;
            color: #f8fafc;
            padding: 32px 30px;
            border-radius: 24px;
            display: flex;
            flex-direction: column;
            gap: 22px;
            text-decoration: none !important;
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.06);
            box-shadow: 0 22px 50px rgba(0, 0, 0, 0.22);
            position: relative;
            overflow: hidden;
        }

        .related-minimal-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.28);
            border-color: rgba(255, 255, 255, 0.18);
        }

        .related-minimal-item:hover::before {
            transform: translate(2px, -2px);
            opacity: 1;
        }

        .related-card-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
        }

        .related-card-main-left {
            min-width: 0;
            flex: 1 1 60%;
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .related-item-title {
            font-size: 1.6rem;
            font-weight: 700;
            line-height: 1.05;
            margin: 0;
            color: #ffffff;
        }

        .related-item-details {
            display: flex;
            flex-wrap: wrap;
            gap: 12px 16px;
            font-size: 14px;
            color: #cbd5e1;
            align-items: center;
        }

        .related-item-details span {
            display: flex;
            align-items: center;
            gap: 6px;
            min-width: 0;
            max-width: 100%;
        }

        .related-item-icon {
            width: 18px;
            height: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            flex-shrink: 0;
        }

        .related-item-icon svg {
            width: 16px;
            height: 16px;
            color: inherit;
            fill: none;
        }

        .related-card-icon {
            width: 48px;
            height: 48px;
            min-width: 48px;
            border-radius: 14px;
            border: 1px solid rgba(255,255,255,0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 16px;
            background: rgba(255,255,255,0.05);
            flex-shrink: 0;
        }

        .related-card-icon svg {
            width: 16px;
            height: 16px;
            color: currentColor;
            stroke: currentColor;
        }

        .related-card-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            width: 100%;
            margin-top: 10px;
        }

        .related-card-bottom .related-card-left,
        .related-card-bottom .related-card-right {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .related-card-left {
            justify-content: flex-start;
        }

        .related-card-right {
            justify-content: flex-end;
        }

        .related-team-pill {
            display: inline-flex;
            padding: 8px 18px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.14);
            background: rgba(255, 255, 255, 0.04);
            font-size: 13px;
            color: #f8fafc;
        }

        .related-team-pill--top {
            display: none;
        }

        .related-card-meta-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            margin-bottom: 16px;
        }

        .related-card-bottom .job-badge {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.16);
            padding: 10px 18px;
            border-radius: 999px;
            font-size: 13px;
            color: #f8fafc;
        }

        .related-card-bottom .badge-status.is-open {
            color: #4ade80;
            border-color: rgba(74, 222, 128, 0.35);
        }

        .related-card-bottom .badge-status.is-expired {
            color: #fda4af;
            border-color: rgba(251, 113, 133, 0.35);
        }

        .related-card-bottom .badge-date {
            color: #94a3b8;
            border-color: rgba(255, 255, 255, 0.16);
        }

        .see-more-wrap {
            text-align: center;
            margin-top: 32px;
        }

        .see-more-btn {
            background: transparent;
            border: 1px solid #fff;
            color: #fff;
            padding: 12px 34px;
            border-radius: 40px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .see-more-btn::after {
            content: "";
            width: 14px;
            height: 14px;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="7" x2="17" y2="17"/><polyline points="7 17 17 17 17 7"/></svg>');
            background-size: contain;
            background-repeat: no-repeat;
        }

        .see-more-btn:hover {
            background: #fff;
            color: #111;
        }

        .related-minimal-item.is-hidden { display: none; }

        @media (max-width: 1024px) {
            .related-minimal-grid {
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            }

            .related-card-icon {
                width: 44px;
                height: 44px;
                min-width: 44px;
            }

            .job-meta {
                flex-wrap: wrap;
                gap: 12px;
            }
        }

        @media (max-width: 768px) {
            .related-minimal-grid {
                grid-template-columns: 1fr;
            }

            .related-card-top {
                flex-direction: row;
                justify-content: space-between;
                align-items: flex-start;
                flex-wrap: wrap;
                gap: 14px;
            }

            .related-card-main-left {
                flex: 1 1 calc(100% - 56px);
                min-width: 0;
            }

            .related-card-icon {
                width: 40px;
                height: 40px;
                min-width: 40px;
                flex-shrink: 0;
                align-self: flex-start;
            }

            .related-item-details {
                gap: 10px 10px;
                font-size: 13px;
            }

            .related-card-bottom {
                flex-direction: row;
                align-items: center;
                justify-content: flex-start;
                flex-wrap: nowrap;
                gap: 10px;
            }

            .related-card-bottom .related-card-left {
                display: none;
            }

            .related-card-bottom .related-card-right {
                width: auto;
                justify-content: flex-start;
                flex-wrap: nowrap;
                gap: 10px;
                margin-top: 0;
            }

            .related-card-bottom .job-badge,
            .related-card-bottom .badge-status,
            .related-card-bottom .badge-date {
                white-space: nowrap;
            }

            .related-team-pill--top {
                display: inline-flex;
            }

            .related-card-top {
                align-items: flex-start;
            }

            .related-card-bottom .job-badge,
            .related-card-bottom .badge-status,
            .related-card-bottom .badge-date {
                width: auto;
            }

            :root { --page-padding-left: 20px; }
            .job-title { font-size: 42px; letter-spacing: -1.5px; }
            .job-meta { flex-wrap: wrap; font-size: 15px; gap: 10px; }
            .related-minimal-item { flex-direction: column; align-items: flex-start; gap: 15px; }
            .related-item-details { flex-wrap: wrap; gap: 10px 20px; }
        }

        /* Popup Box Custom */
        .white-popup {
            background-color: white !important;
            border-radius: 20px !important;
            padding: 40px !important;
            max-width: 600px;
            margin: 0 auto;
            position: relative;
        }

        .custom-close-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            cursor: pointer;
            font-size: 20px;
            color: #999;
        }

        /* Tablet/Mobile Responsive */
        @media (max-width: 1024px) {
            .job-title { font-size: 56px; letter-spacing: -2px; }
            .recru-hero { flex-direction: column; align-items: flex-start; gap: 30px; }
            .apply-btn-minimal { width: 100%; justify-content: center; }
        }

        @media (max-width: 768px) {
            :root { --page-padding-left: 20px; }
            .job-title { font-size: 42px; letter-spacing: -1.5px; }
            .job-meta { flex-wrap: wrap; font-size: 15px; gap: 10px; }
            .related-minimal-item { flex-direction: column; align-items: flex-start; gap: 15px; }
            .related-item-details { flex-wrap: wrap; gap: 10px 20px; }
        }
    </style>
<?php endif; ?>

<div class="<?= $is_recru ? 'recru-master' : 'entry-content single-page' ?>">
    <div class="<?= $is_recru ? 'recru-container' : '' ?>">
        
        <?php if ($is_recru) : ?>
            
            <div class="recru-breadcrumb">
                <a href="/careers/">Careers</a> / <strong><?= get_the_title() ?></strong>
            </div>

            <div class="recru-hero">
                <div class="recru-hero-left">
                    <h1 class="job-title"><?= get_the_title() ?></h1>
                    <div class="job-meta">
                        <?php 
                        $loc_field = get_field_object('location'); 
                        $loc_display = ($loc_field && !empty($loc_field['value'])) ? $loc_field['choices'][$loc_field['value']] : $data['loc'];
                        ?>

                        <?php if($data['exp']): ?>
                            <span><?= esc_html($data['exp']) ?></span>
                            <div class="meta-dot"></div>
                        <?php endif; ?>

                        <span><?= esc_html($loc_display ?: 'Ho Chi Minh City') ?></span>
                        <div class="meta-dot"></div>

                        <span><?= esc_html($data['sal'] ?: 'Negotiable') ?></span>
                        <div class="meta-dot"></div>

                        <span><?= $data['pos'] ?: '1' ?> positions</span>
                        <div class="meta-dot"></div>

                        <span>Date: <?= get_the_date('d/m/Y') ?></span>
                        <div class="meta-dot"></div>

                        <span>Status: <?= $job_expired ? 'Closed' : 'Open' ?></span>
                    </div>
                </div>
                <div class="recru-hero-right">
                    <?php if ($job_expired) : ?>
                        <span class="apply-btn-minimal apply-btn-minimal--disabled">
                            Apply Now
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><path d="M7 17l10-10"></path><polyline points="7 7 17 7 17 17"></polyline></svg>
                        </span>
                    <?php else : ?>
                        <a href="#apply-form-popup" class="apply-btn-minimal open-popup-btn">
                            Apply Now
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><path d="M7 17l10-10"></path><polyline points="7 7 17 7 17 17"></polyline></svg>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <hr class="full-width-divider">

            <div class="job-content-wrap">
                <h2 class="section-header"><div class="black-circle-icon"></div> Job Description</h2>
                <div class="job-details-content">
                    <?php the_content(); ?>
                </div>
            </div>

            <div class="related-minimal">
                <h3 class="related-minimal-title">More Opportunities</h3>
                <div class="related-minimal-grid">
                    <?php
                    $related = new WP_Query([
                        'post_type'      => 'post', 
                        'posts_per_page' => 12, // Fetch more to allow "See More"
                        'post__not_in'   => [$current_id], 
                        'category_name'  => 'carreers'
                    ]);

                    $count = 0;
                    if ($related->have_posts()) : while ($related->have_posts()) : $related->the_post();
                        $count++;
                        $r_loc_obj = get_field_object('location');
                        $r_loc_display = (isset($r_loc_obj['choices']) && isset($r_loc_obj['value'])) ? $r_loc_obj['choices'][$r_loc_obj['value']] : get_field('location');
                        $hidden_class = ($count > 4) ? 'is-hidden' : '';
                        $r_team     = get_field('team');
                        $team_field = get_field_object('team');
                        $r_team_label = $r_team;
                        if ($r_team && $team_field && !empty($team_field['choices']) && isset($team_field['choices'][$r_team])) {
                            $r_team_label = $team_field['choices'][$r_team];
                        }
                        $r_pos       = get_field('positions');
                        $r_exp       = get_field('experience');
                        $r_salary    = get_field('salary');
                        $r_exp_date  = get_field('expirydate');
                        $r_expired   = ($r_exp_date && strtotime($r_exp_date) < strtotime(date('Y-m-d')));
                    ?>
                        <a href="<?php the_permalink(); ?>" class="related-minimal-item <?= $hidden_class ?>">
                            <div class="related-card-top">
                                <div class="related-card-main-left">
                                    <?php if ($r_team_label) : ?>
                                        <div class="related-card-meta-top">
                                            <span class="related-team-pill related-team-pill--top"><?= esc_html($r_team_label) ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <h4 class="related-item-title"><?php the_title(); ?></h4>
                                    <div class="related-item-details">
                                        <span><span class="related-item-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></span><?= esc_html($r_loc_display ?: 'Vietnam') ?></span>
                                        <span><span class="related-item-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1v22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></span><?= esc_html($r_salary ?: 'Negotiable') ?></span>
                                        <span><span class="related-item-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21V9a3 3 0 0 1 6 0v12"/><path d="M5 21h14"/><path d="M9 7a3 3 0 0 1 6 0"/></svg></span><?= esc_html($r_exp ?: 'No experience') ?></span>
                                        <?php if ($r_pos) : ?>
                                            <span><span class="related-item-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></span><?= esc_html($r_pos) ?> positions</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="related-card-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><path d="M7 17l10-10"/><polyline points="7 7 17 7 17 17"/></svg>
                                </div>
                            </div>
                            <div class="related-card-bottom">
                                <div class="related-card-left">
                                    <?php if ($r_team_label) : ?>
                                        <span class="related-team-pill"><?= esc_html($r_team_label) ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="related-card-right">
                                    <?php if ($r_expired) : ?>
                                        <span class="job-badge badge-status is-expired">Status • Closed</span>
                                    <?php else : ?>
                                        <span class="job-badge badge-status is-open">Status • Open</span>
                                    <?php endif; ?>
                                    <?php if ($r_exp_date) : ?>
                                        <span class="job-badge badge-date">Date <?= date('F d, Y', strtotime($r_exp_date)) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    <?php endwhile; wp_reset_postdata(); endif; ?>
                </div>
                
                <?php if ($count > 4) : ?>
                    <div class="see-more-wrap">
                        <button class="see-more-btn" id="seeMoreJobs">See More Positions</button>
                    </div>
                <?php endif; ?>
            </div>

            <script>
                jQuery(document).ready(function($) {
                    $('#seeMoreJobs').on('click', function() {
                        $('.related-minimal-item.is-hidden').fadeIn().removeClass('is-hidden');
                        $(this).parent().fadeOut();
                    });
                });
            </script>

            <div id="apply-form-popup" class="mfp-hide">
                <div class="white-popup">
                    <div class="custom-close-btn" onclick="jQuery.magnificPopup.close();">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </div>
                    <div style="text-align:center;">
                        <h3 style="font-weight:700; text-transform:uppercase; font-size: 20px; margin-bottom:10px; color:#333;">Application Form</h3>
                        <p style="color:#888; margin-bottom:30px; font-size: 14px;">Position: <span style="color:#333; font-weight:700;"><?= get_the_title() ?></span></p>
                    </div>
                    <?= do_shortcode('[contact-form-7 id="a7aed24" title="careers"]') ?>
                </div>
            </div>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
            <script>
                jQuery(document).ready(function($) {
                    var jobTitle = <?= json_encode(get_the_title()) ?>;
                    $('.open-popup-btn').magnificPopup({
                        type: 'inline',
                        midClick: true,
                        mainClass: 'mfp-fade',
                        showCloseBtn: false,
                        removalDelay: 300,
                        callbacks: {
                            open: function() {
                                var jobField = $('#apply-form-popup input[name="your-job-title"]');
                                if (jobField.length) {
                                    jobField.val(jobTitle);
                                }
                            }
                        }
                    });
                });
            </script>

        <?php else :
            $aid = get_the_author_meta('ID');
            $author_name = esc_html(get_the_author_meta('display_name'));
            $author_desc = esc_html(get_the_author_meta('description') ?: 'Author at ' . get_bloginfo('name'));
            $category_obj = get_the_category();
            $category_name = $category_obj ? esc_html($category_obj[0]->name) : 'Blog';
            $article_excerpt = wp_trim_words(strip_tags(get_the_excerpt() ?: get_the_content()), 40);
            $article_image = get_the_post_thumbnail_url($current_id, 'large') ?: 'https://images.unsplash.com/photo-1614850523296-d8c1af93d400?auto=format&fit=crop&q=80&w=1200';
            $related_query = new WP_Query([
                'post_type'      => 'post',
                'posts_per_page' => 3,
                'post__not_in'   => [$current_id],
                'orderby'        => 'date',
                'order'          => 'DESC',
            ]);
        ?>
        <style>
            .custom-article-page * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            .custom-article-page {
                font-family: 'Inter', sans-serif;
                background-color: #ffffff;
                color: #1a1a1a;
                padding: 0 20px 60px;
            }
            .custom-article-page .container {
                max-width: 1800px;
                width: 100%;
                margin: 0 auto;
                padding: 0 80px;
            }
            .entry-header,
            .post-sidebar,
            .sidebar,
            .widget,
            #comments,
            #reviews,
            .comments-area,
            .single .post-sidebar,
            .single .sidebar {
                display: none !important;
            }
            .custom-article-page .breadcrumb {
                padding: 18px 0;
                font-size: 13px;
                color: #999;
                border-top: 1px solid #f2f2f2;
                border-bottom: 1px solid #f2f2f2;
                margin-bottom: 60px;
            }
            .custom-article-page .breadcrumb b {
                color: #333;
            }
            .custom-article-page {
                font-family: 'Inter', sans-serif;
                background-color: #ffffff;
                color: #1a1a1a;
                padding: 0 20px 60px;
                min-width: 1180px;
            }
            .custom-article-page .container {
                max-width: 1800px;
                width: calc(100% - 80px);
                margin: 0 auto;
                padding: 0 40px;
            }
            .custom-article-page {
                font-family: 'Inter', sans-serif;
                background-color: #ffffff;
                color: #1a1a1a;
                padding: 0 20px 60px;
                min-width: 1180px;
            }
            .custom-article-page .container {
                max-width: 1920px;
                width: calc(100% - 80px);
                margin: 0 auto;
                padding: 0 40px;
            }
            .custom-article-page .layout {
                display: grid;
                grid-template-columns: 260px minmax(820px, 1fr) 320px;
                gap: 50px;
                align-items: start;
            }
            .custom-article-page .sidebar-left {
                width: 260px;
                background: transparent;
                border-radius: 0;
                padding: 0;
                box-shadow: none;
                position: sticky;
                top: 120px;
                align-self: start;
            }
            .custom-article-page .sidebar-left h3 {
                font-size: 14px;
                font-weight: 700;
                margin-bottom: 18px;
                text-transform: uppercase;
                letter-spacing: 0.1em;
                color: #111;
            }
            .custom-article-page .sidebar-left ul {
                list-style: none;
                padding: 0;
                margin: 0;
                display: grid;
                gap: 12px;
            }
            .custom-article-page .sidebar-left a {
                display: block;
                text-decoration: none;
                color: #333;
                font-size: 14px;
                font-weight: 500;
                transition: color 0.2s ease;
            }
            .custom-article-page .sidebar-left a:hover {
                color: #0073e6;
            }
            .custom-article-page .sidebar-left li {
                padding: 0;
                margin: 0;
            }
            .custom-article-page .sidebar-right {
                position: sticky;
                top: 120px;
            }
            .custom-article-page .sidebar-right h3 {
                font-size: 14px;
                font-weight: 700;
                margin-bottom: 24px;
                color: #111;
                letter-spacing: 0.08em;
                text-transform: uppercase;
            }
            .custom-article-page .main-article h1 {
                font-size: 54px;
                line-height: 1.05;
            }
                        @media screen and (min-width: 850px) {
    .large-9 {
        flex-basis: 100% !important;
        max-width: 100% !important;
    }
}

            .custom-article-page .article-desc {
                font-size: 18px;
                margin-bottom: 45px;
            }
            .custom-article-page .breadcrumb b {
                color: #555;
                font-weight: 600;
                margin-left: 5px;
            }
            .custom-article-page .layout {
                display: grid;
                grid-template-columns: 260px minmax(820px, 1fr) 320px;
                gap: 60px;
            }
            .custom-article-page .sidebar-left {
                width: 260px;
                position: sticky;
                top: 120px;
                background: transparent;
                padding: 0;
                box-shadow: none;
                border-radius: 0;
            }
            .custom-article-page .sidebar-right {
                width: 320px;
                position: sticky;
                top: 120px;
            }
            .custom-article-page .main-article {
                min-width: 820px;
            }
            .custom-article-page .main-article h1 {
                font-size: 42px;
                font-weight: 700;
                line-height: 1.15;
                letter-spacing: -0.02em;
                margin-bottom: 35px;
                color: #222;
            }
            .custom-article-page .article-desc {
                font-size: 16px;
                color: #888;
                line-height: 1.7;
                margin-bottom: 40px;
            }
            .custom-article-page .meta-data {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 25px 0;
                border-top: 1px solid #eee;
                flex-wrap: wrap;
                gap: 15px;
            }
            .custom-article-page .author-info {
                font-size: 13px;
                font-weight: 600;
            }
            .custom-article-page .author-info span {
                color: #bbb;
                font-weight: 400;
                margin-left: 15px;
            }
            .custom-article-page .category-tag {
                background: #f0f0f0;
                padding: 4px 12px;
                border-radius: 15px;
                font-size: 10px;
                font-weight: 700;
                color: #999;
                text-transform: uppercase;
            }
            .custom-article-page .hero-image {
                width: 100%;
                margin-top: 20px;
            }
            .custom-article-page .hero-image img {
                width: 100%;
                display: block;
                filter: grayscale(0.2);
            }
            .custom-article-page .related-item {
                display: flex;
                gap: 15px;
                margin-bottom: 25px;
                align-items: flex-start;
                padding-bottom: 25px;
                border-bottom: 1px solid #f9f9f9;
            }
            .custom-article-page .related-item:last-child {
                border: none;
                margin-bottom: 0;
                padding-bottom: 0;
            }
            .custom-article-page .related-img {
                flex-shrink: 0;
                width: 90px;
                height: 65px;
                background: #eee;
                overflow: hidden;
            }
            .custom-article-page .related-img img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            .custom-article-page .related-text {
                font-size: 12px;
                font-weight: 500;
                line-height: 1.4;
                color: #333;
            }
            .custom-article-page .related-text:hover {
                text-decoration: underline;
            }
            .custom-article-page .article-content h2,
            .custom-article-page .article-content h3,
            .custom-article-page .article-content h4 {
                scroll-margin-top: 120px;
            }
            .custom-article-page .sidebar-left nav ul {
                list-style: none;
                padding: 0;
                margin: 0;
                display: grid;
                gap: 12px;
            }
            .custom-article-page .sidebar-left nav a {
                color: #333;
                font-size: 14px;
                display: inline-block;
                transition: color .2s ease;
            }
            .custom-article-page .sidebar-left nav a:hover {
                color: #0073e6;
            }
        </style>

        <div class="custom-article-page">
            <div class="">
                <div class="breadcrumb">
                    Blog / <b><?php echo esc_html(get_the_title()); ?></b>
                </div>

                <div class="layout">
                    <aside class="sidebar-left">
                        <h3>Table of contents</h3>
                        <nav id="article-toc">
                            <ul></ul>
                        </nav>
                    </aside>

                    <main class="main-article" id="section-article">
                        <h1><?php echo esc_html(get_the_title()); ?></h1>
                        <p class="article-desc"><?php echo esc_html($article_excerpt); ?></p>
                        <div class="meta-data">
                            <div class="author-info">
                                <?php echo esc_html($author_name); ?> <span><?php echo esc_html(get_the_date('M d, Y')); ?></span>
                            </div>
                            <div class="category-tag"><?php echo esc_html($category_name); ?></div>
                        </div>
                        <div class="hero-image">
                            <img src="<?php echo esc_url($article_image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                        </div>
                        <div class="article-content" style="margin-top:40px; font-size:18px; line-height:1.85; color:#333;">
                            <?php the_content(); ?>
                        </div>
                    </main>

                    <aside class="sidebar-right" id="section-related">
                        <h3>Related blogs</h3>
                        <?php if ($related_query->have_posts()) : while ($related_query->have_posts()) : $related_query->the_post(); ?>
                            <div class="related-item">
                                <div class="related-img">
                                    <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium') ?: 'https://images.unsplash.com/photo-1496171367470-9ed9a91ea931?auto=format&fit=crop&q=80&w=200'); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                                </div>
                                <div class="related-text">
                                    <a href="<?php the_permalink(); ?>"><?php echo esc_html(get_the_title()); ?></a>
                                </div>
                            </div>
                        <?php endwhile; wp_reset_postdata(); endif; ?>
                    </aside>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var content = document.querySelector('.custom-article-page .article-content');
                var tocList = document.querySelector('#article-toc ul');
                if (!content || !tocList) return;

                var headings = content.querySelectorAll('h2, h3, h4');
                if (!headings.length) {
                    document.querySelector('.custom-article-page .sidebar-left').style.display = 'none';
                    return;
                }

                headings.forEach(function(heading, index) {
                    if (!heading.id) {
                        var slug = heading.textContent.trim().toLowerCase().replace(/[^a-z0-9\s]/g, '').replace(/\s+/g, '-');
                        heading.id = 'toc-' + index + '-' + slug;
                    }
                    var listItem = document.createElement('li');
                    var anchor = document.createElement('a');
                    anchor.href = '#' + heading.id;
                    anchor.textContent = heading.textContent.trim();
                    if (heading.tagName.toLowerCase() === 'h3') {
                        anchor.style.paddingLeft = '10px';
                        anchor.style.fontSize = '13px';
                    }
                    if (heading.tagName.toLowerCase() === 'h4') {
                        anchor.style.paddingLeft = '18px';
                        anchor.style.fontSize = '13px';
                    }
                    listItem.appendChild(anchor);
                    tocList.appendChild(listItem);
                });
            });
        </script>

        <?php endif; ?>
    </div>
</div>
