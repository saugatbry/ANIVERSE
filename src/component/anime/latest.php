<section class="block_area block_area_category lazy-component" data-component="category">
    <div class="block_area-header">
        <div class="float-left bah-heading mr-4">
            <h2 class="cat-heading">Latest Episode</h2>
        </div>
        <div class="float-right viewmore">
            <a class="btn" href="/anime/recently-updated">View more<i class="fas fa-angle-right ml-2"></i></a>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="tab-content">
        <div class="block_area-content block_area-list film_list film_list-grid film_list-wfeature">
            <div class="film_list-wrap">
                <?php
                $payload = @file_get_contents("$zpi/newadded");
                $json = $payload ? json_decode($payload, true) : [];
                $rows = $json['results']['data'] ?? $json['results']['results'] ?? $json['results'] ?? [];
                if (!is_array($rows)) $rows = [];

                $animeList = array_slice($rows, 0, 12);
                foreach ($animeList as $anime):
                    $animeId = $anime['id'] ?? $anime['anime_id'] ?? '';
                    $title = $anime['title'] ?? 'Unknown';
                    $jname = $anime['jname'] ?? $title;
                    $tvInfo = $anime['tvInfo'] ?? [];
                    $subCount = $tvInfo['sub'] ?? ($anime['episode'] ?? null);
                    $dubCount = $tvInfo['dub'] ?? null;
                ?>
                <div class="flw-item">
                    <div class="film-poster">
                        <?php if (!empty($anime['adultContent'])): ?>
                            <div class="tick ltr" style="position:absolute;top:10px;left:10px;">
                                <div class="tick-item tick-age amp-algn">18+</div>
                            </div>
                        <?php endif; ?>

                        <div class="tick ltr" style="position:absolute;bottom:10px;left:10px;">
                            <?php if (!empty($subCount)): ?>
                                <div class="tick-item tick-sub amp-algn" style="text-align:left;">
                                    <i class="fas fa-closed-captioning"></i> &nbsp; <?= htmlspecialchars((string)$subCount) ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($dubCount)): ?>
                                <div class="tick-item tick-dub amp-algn" style="text-align:left;">
                                    <i class="fas fa-microphone"></i> &nbsp; <?= htmlspecialchars((string)$dubCount) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <img class="film-poster-img lazyload"
                             data-src="<?= htmlspecialchars($anime['poster'] ?? $websiteUrl . '/public/images/no_poster.jpg') ?>"
                             src="<?= $websiteUrl ?>/public/images/no_poster.jpg"
                             alt="<?= htmlspecialchars($title) ?>">
                        <a class="film-poster-ahref has-qtip"
                           href="/details/<?= htmlspecialchars($animeId) ?>"
                           title="<?= htmlspecialchars($title) ?>"
                           data-jname="<?= htmlspecialchars($jname) ?>"><i class="fas fa-play"></i></a>
                    </div>
                    <div class="film-detail">
                        <h3 class="film-name">
                            <a href="/details/<?= htmlspecialchars($animeId) ?>" class="dynamic-name"
                               data-title="<?= htmlspecialchars($title) ?>"
                               data-jname="<?= htmlspecialchars($jname) ?>"><?= htmlspecialchars($title) ?></a>
                        </h3>
                        <div class="fd-infor">
                            <span class="fdi-item"><?= htmlspecialchars($tvInfo['showType'] ?? (!empty($anime['season']) ? 'Season ' . $anime['season'] : 'TV')) ?></span>
                            <span class="dot"></span>
                            <span class="fdi-item"><?= htmlspecialchars($tvInfo['duration'] ?? ($anime['run_time'] ?? 'N/A')) ?></span>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</section>
