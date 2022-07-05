<div id="gData" data-toiuser="<?= $this->data->iuser ?>" data-loginIuser="<?= getIuser() ?>"
data-="<?= $this->data->mainimg ?>" data-nm="<?= $this->data->nm ?>"></div>
<div class="d-flex flex-column align-items-center">
    <div class="size_box_100"></div>
        <div class="w100p_mw614">
            <div class="d-flex flex-row">            
                <div class="d-flex flex-column justify-content-center me-3">                
                    <div class="circleimg h150 w150 pointer feedwin">                    
                        <img data-bs-toggle="modal" data-bs-target="#changeProfileImgModal" src='/static/img/profile/<?= $this->data->iuser ?>/<?= $this->data
    ->mainimg ?>' onerror='this.error=null;this.src="/static/img/profile/defaultProfileImg_100.png"'>
                    </div>
                </div>     
                <div class="flex-grow-1 d-flex flex-column justify-content-evenly">
                    <div><?= $this->data->email ?>
                    <?php if ($this->data->iuser === getIuser()) {
                        echo '<button type="button" id="btnModProfile" class="btn btn-outline-secondary">프로필 수정</button>';
                    } else {
                        $data_follow = 0;
                        $cls = 'btn-primary';
                        $txt = '팔로우';

                        if ($this->data->meyou === 1) {
                            $data_follow = 1;
                            $cls = 'btn-outline-secondary';
                            $txt = '팔로우 취소';
                        } elseif ($this->data->youme === 1 && $this->data->meyou === 0) {
                            $txt = '맞팔로우 하기';
                        }
                        echo "<button type='button' id='btnFollow' data-youme = '{$this->data->youme}' data-follow='{$data_follow}' class='btn {$cls}'>{$txt}</button>";
                    } ?></div>
                    <div class="d-flex flex-row">
<div class="flex-grow1 me-3">게시물 <span class="bold"><?= $this->data->feedcnt ?></span></div>
                    <div class="flex-grow1 me-3">팔로워 <span class="bold follower"><?= $this->data->followerCnt ?></span></div>
                    <div class="flex-grow1">팔로우 <span class="bold"><?= $this->data->followCnt ?></span></div>
                    </div>
                    <div class="bold"><?= $this->data->nm ?></div>
                    <div><?= $this->data->cmt ?></div>
                </div>
            </div>
        <div id="item_container"></div>
    </div>
    <div class="loading d-none"><img src="/static/img/loading.gif"></div>
</div>

    <!-- Modal -->

        <div class="modal fade" id="profileMod" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog d-flex modal-dialog-centered modal-md">
            <div class="modal-content">
              <div class="modal-header w100p_mw614 justify-content-center">
                <h5 class="_modal-title w100p_mw614" id="staticBackdropLabel">프로필 사진 바꾸기</h5>
                    </div>
                    <div class="_modal-body modal-body bold-blue w100p_mw614 pointer">
                        사진 업로드
                    </div>
                    <div class="_modal-body modal-body bold-red w100p_mw614 pointer not-border">
                        현재 사진 삭제
                    </div>
                    <div class="_modal-footer modal-footer w100p_mw614 pointer" data-bs-dismiss="modal">
                        취소
                    </div>
                </div>
            </div>
        </div>
            </div>
        </div>
    </div>
</div>
</body>