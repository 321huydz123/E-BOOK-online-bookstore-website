 <div class="row mt-60">
                            <div class="col-12">
                                <h3 class="section-t    itle style-1 mb-30">Sản Phẩm Liên Quan</h3>
                            </div>
                            <div class="col-12">
                                <div class="row related-products">
                                    <?php
                                    $count_one = 0;
                                    foreach ($lien_quan as $key => $vl) {
                                        $count_one++; ?>

                                    <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                        <div class="product-cart-wrap small hover-up">
                                            <div class="product-img-action-wrap">
                                                <div class="product-img product-img-zoom">
                                                    <a href="index.php?controller=sanPham_view&id=<?php echo $vl->id_san_pham ?>&loai=<?php echo $vl->id_loai_san_pham ?>&botruyen=<?php echo $vl->id_bo_truyen ?>"
                                                        tabindex="0">
                                                        <img class="default-img"
                                                            src="assets/imgs/shop/<?php echo $vl->hinh_anh ?>" alt="">
                                                        <img class="hover-img"
                                                            src="assets/imgs/shop/<?php echo $vl->hinh_anh ?>" alt="">
                                                    </a>
                                                </div>
                                                <div class="product-action-1">
                                                    <a aria-label="Quick view" class="action-btn hover-up"
                                                        href="index.php?controller=sanPham_view&id=<?php echo $vl->id_san_pham ?>&loai=<?php echo $vl->id_loai_san_pham ?>&botruyen=<?php echo $vl->id_bo_truyen ?>"><i
                                                            class="fi-rs-eye"></i></a>

                                                    <a aria-label="Mua ngay" class="action-btn hover-up"
                                                        href="index.php?controller=sanPham_view&id=<?php echo $vl->id_san_pham ?>&loai=<?php echo $vl->id_loai_san_pham ?>&botruyen=<?php echo $vl->id_bo_truyen ?>"><i
                                                            class="fas fa-truck"></i></i></a>
                                                </div>

                                            </div>
                                            <div class="product-content-wrap">
                                                <h2><a
                                                        href="index.php?controller=sanPham_view&id=<?php echo $vl->id_san_pham ?>&loai=<?php echo $vl->id_loai_san_pham ?>&botruyen=<?php echo $vl->id_bo_truyen ?>">
                                                        <?php echo $vl->ten_san_pham ?>
                                                    </a></h2>
                                                <div class="rating-result" title="90%">
                                                    <span>
                                                    </span>
                                                </div>
                                                <div class="product-price">
                                                    <span><?php echo  number_format($vl->gia_ban, 0, ',', ',') ?>
                                                        VND</span> <br>
                                                    <span
                                                        class="old-price"><?php echo  number_format($vl->gia_goc, 0, ',', ',') ?>
                                                        VND</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        if ($count_one == 4) {
                                            break;
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
