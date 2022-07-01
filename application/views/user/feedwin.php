<div class="d-flex flex-column align-items-center">
    <div class="size_box_100"></div>
    <div class="w100p_mw614">
        <div class="d-flex flex-row">            
            <div class="d-flex flex-column justify-content-center me-3">                
                <div class="circleimg h150 w150 pointer feedwin">                    
                    <img data-bs-toggle="modal" data-bs-target="#changeProfileImgModal" src='/static/img/profile/<?= $this
                        ->data->iuser ?>/<?= $this->data
    ->mainimg ?>' onerror='this.error=null;this.src="/static/img/profile/defaultProfileImg_100.png"'>
                </div>
            </div>            
            <div class="flex-grow-1 d-flex flex-column justify-content-evenly">
                <div><?php
                $this->data->email;
                if (getIuser() == $this->data->iuser) { ?> 
                     <button type="button" id="btnModProfile" class="btn btn-outline-secondary">프로필수정</button>
                     <?php } elseif (
                    $this->data->youme == 1 &&
                    $this->data->meyou == 0
                ) { ?> 
                     <button type="button" id="btnFollow" data-follow='0' class="btn btn-primary">맞팔로우 하기</button>
                     <?php } elseif ($this->data->meyou == 1) { ?> 
                     <button type="button"  id="btnFollow" data-follow='0' class="btn btn-primary">팔로우 취소</button>
                     <?php } elseif ($this->data->meyou == 0) { ?> 
                     <button type="button"  id="btnFollow" data-follow='1' class="btn btn-primary">팔로우</button>
                     <?php } else {print '휴..';}
                ?>  </div>
                <div class="d-flex flex-row">
                    <div class="flex-grow-1 me-3">게시물 <span class="bold">
                        <?= $this->data->feedcnt ?></span></div>
                    <div class="flex-grow-1 me-3">팔로워 <span class="bold">
                        <?= $this->data->follower ?></span></div>
                    <div class="flex-grow-1">팔로우 <span class="bold">
                        <?= $this->data->follow ?></span></div>
                </div>
                <div class="bold"><?= $this->data->nm ?></div>
                <div><?= $this->data->cmt ?></div>
            </div>
        </div>

    </div>
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