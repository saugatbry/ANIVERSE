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
                        <div class="tab-content">
                            <div class="block_area-content block_area-list film_list film_list-grid film_list-wfeature ">
                                <div class="film_list-wrap">
                                    
                                    <?php
                                    // Fetch JSON data
                                    $ch = curl_init();
                                    curl_setopt($ch, CURLOPT_URL, "$zpi/newadded");
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                    $json = curl_exec($ch);
                                    curl_close($ch);
                                    $json = json_decode($json, true);

                                    // Check if 'results' and 'data' exist
                                    if (isset($json['results']) && is_array($json['results'])) {
                                        $animeList = $json['results']['data'] ?? $json['results'];
                                        if (isset($animeList['results']) && is_array($animeList['results'])) { $animeList = $animeList['results']; }
                                        $animeList = array_slice($animeList, 0, 12);
                                        foreach ($animeList as $anime) { ?>
                                            <?php if (!empty($anime['tvInfo']['sub'])): ?>
                                            <div class="flw-item">
                                                <div class="film-poster">
                                                    <!-- Age Indicator -->
                                                    <?php if ($anime['adultContent']) { ?>
                                                        <div class="tick ltr" style="position: absolute; top: 10px; left: 10px;">
                                                            <div class="tick-item tick-age amp-algn">18+</div>
                                                        </div>
                                                    <?php } ?>
                                                    <!-- Sub and Dub Counts -->
                                                    <div class="tick ltr" style="position: absolute; bottom: 10px; left: 10px;">
                                                        <div class="tick-item tick-sub amp-algn" style="text-align: left;">
                                                            <i class="fas fa-closed-captioning"></i> &nbsp; <?= isset($anime['tvInfo']['sub']) ? htmlspecialchars($anime['tvInfo']['sub']) : '' ?>
                                                        </div>
                                                        <?php if(!empty($anime['tvInfo']['dub'])): ?>
                                                        <div class="tick-item tick-dub amp-algn" style="text-align: left;">
                                                            <i class="fas fa-microphone"></i> &nbsp; <?= isset($anime['tvInfo']['dub']) ? htmlspecialchars($anime['tvInfo']['dub']) : '' ?>
                                                        </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <!-- Anime Poster -->
                                                    <img class="film-poster-img lazyload"
                                                        data-src="<?= $anime['poster'] ?>"
                                                        src="<?= $websiteUrl ?>/public/images/no_poster.jpg"
                                                        alt="<?= $anime['title'] ?? 'Unknown' ?>">
                                                    <a class="film-poster-ahref has-qtip"
                                                        href="/details/<?= ($anime['id'] ?? $anime['anime_id'] ?? '') ?>"
                                                        title="<?= $anime['title'] ?? 'Unknown' ?>"
                                                        data-jname="<?= $anime['title'] ?? 'Unknown' ?>"><i class="fas fa-play"></i></a>
                                                </div>
                                                <div class="film-detail">
                                                     <h3 class="film-name">
                                                        <a href="/details/<?= ($anime['id'] ?? $anime['anime_id'] ?? '') ?>"
                                                            class="dynamic-name"
                                                            data-title="<?= htmlspecialchars($anime['title'] ?? 'Unknown') ?>" data-jname="<?= htmlspecialchars($anime['jname']) ?>"><?= htmlspecialchars($anime['title'] ?? 'Unknown') ?></a>
                                                        </h3>
                                                    <div class="fd-infor">
                                                        <span class="fdi-item"><?= htmlspecialchars($anime['tvInfo']['showType'] ?? 'TV') ?></span>
                                                        <span class="dot"></span>
                                                        <span class="fdi-item"><?= htmlspecialchars($anime['tvInfo']['duration'] ?? ($anime['run_time'] ?? 'N/A')) ?></span>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <?php endif; ?>
                                    <?php }
                                    } else {
                                        echo "<p>No anime data available or invalid structure.</p>";
                                    } ?>

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
