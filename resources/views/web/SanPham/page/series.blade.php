  <div class="col-lg-3 primary-sidebar sticky-sidebar">

                    <div class="sidebar-widget product-sidebar  mb-30 p-30 bg-grey border-radius-10">
                        <div class="widget-header position-relative mb-20 pb-10">
                            <h5 class="widget-title mb-10">BỘ TRUYỆN</h5>
                            <div class="bt-1 border-color-1"></div>
                        </div>
                        <form action="index.php?controller=check&nd=thongTin" method="post">
                            <?php
                            $count_one = 0;
                            $sum_list = 0;
                            foreach ($bo_truyen as $key => $vl) {
                                $count_one++; ?>
                            <input type="hidden" name="so_luong" value="0">
                            <div class="single-post clearfix">
                                <div class="image">
                                    <img src="assets/imgs/shop/<?php echo $vl->hinh_anh ?>" alt="#">
                                </div>
                                <div class="content pt-10">
                                    <h5><a
                                            href="index.php?controller=boTruyen_view&id=<?php echo $vl->id_bo_truyen ?>"><?php echo $vl->ten_san_pham ?></a>
                                    </h5>
                                    <p class="price mb-0 mt-5">
                                        <?php $sum_list += $vl->gia_ban;
                                            echo  number_format($vl->gia_ban, 0, ',', ',')  ?> VND
                                    </p>
                                    <input type="hidden" name="card[]" value="<?php echo $vl->id_san_pham ?>">
                                    <input type="hidden" name="boTruyen">
                                    <div class="product-rate">
                                        <div class="product-rating" style="width:90%"></div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                            <div class="widget-header position-relative mb-20 pb-10">
                                <h5 class="widget-title mb-10"><?php echo $sum_list; ?></h5>
                                <div class="bt-1 border-color-1"> <button type="submit">Mua bộ truyện</button></div>
                            </div>
                        </form>
                    </div>
                </div>
