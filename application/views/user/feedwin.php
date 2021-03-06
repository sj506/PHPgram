<div id="gData" data-toiuser="<?= $this->data->iuser ?>" data-loginiuser="<?= getIuser() ?>" data-mainimg="<?= $this->data->mainimg ?>" data-nm="<?= $this->data->nm ?>"></div>
<div class="d-flex flex-column align-items-center">
    <div class="size_box_100"></div>
    <div class="w100p_mw614">
        <div class="d-flex flex-row">
            <div class="d-flex flex-column justify-content-center me-3">
                <div class="circleimg h150 w150 pointer feedwin">
                    <img class="profileimg" id="profileImg" data-bs-toggle="modal" data-bs-target="#changeProfileImgModal" src='/static/img/profile/<?= $this->data->iuser ?>
                        /<?= $this->data->mainimg ?>' onerror='this.error=null;this.src="/static/img/profile/defaultProfileImg_100.png"'>
                </div>
            </div>
            <div class="flex-grow-1 d-flex flex-column justify-content-evenly">
                <div><?= $this->data->email ?>
                    <?php if ($this->data->iuser === getIuser()) {
                      echo '<button type="button" data-bs-toggle="modal" data-bs-target="#profileModal" id="btnModProfile" class="btn btn-outline-secondary">프로필 수정</button>';
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

<!-- 프로필 모달 1 -->

<div class="modal fade" id="changeProfileImgModal" tabindex="-1" aria-labelledby="changeProfileImgModalLabel" style="padding-right: 17px;" aria-modal="true" aria-hidden="true" role="dialog">
    <div class="modal-dialog d-flex modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header w100p_mw614 justify-content-center">
                <h5 class="_modal-title w100p_mw614" id="staticBackdropLabel">프로필 사진 바꾸기</h5>
            </div>
            <div class="_modal-body modal-body bold-blue w100p_mw614 pointer imgUpload text-primary" data-bs-target="#changeProfileImg" data-bs-toggle="modal" id="changeImg">
                <span>사진 업로드</span>
            </div>
            <div id="btnDelCurrentProfilePic" class="_modal-body modal-body bold-red w100p_mw614 pointer not-border imgDel <?php $this->data->mainimg == null ? print 'd-none' : ''; ?>">
                현재 사진 삭제
            </div>
            <div class="_modal-footer modal-footer w100p_mw614 pointer" id="btnModalClose" data-bs-dismiss="modal">
                취소
            </div>
            <form class="d-none imgForm">
                <input type="file" accept="image/*" name="imgs" multiple>
            </form>
        </div>
    </div>
</div>


<!-- 프로필 모달 2 -->

<div class="modal fade" id="changeProfileImg" aria-hidden="true" aria-labelledby="changeProfileImg" tabindex="-1">
    <div class="modal-dialog modal-dia`log-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title bold" id="changeProfileImgLabel">사진 업로드</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="circleimg h300 w300 pointer">
                    <img id="currentProfileImg" class="profileimg" 
                    src='/static/img/profile/<?= $this->data->iuser ?>/<?= $this->data->mainimg ?>' onerror='this.error=null;this.src="/static/img/profile/defaultProfileImg_100.png"'>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="changeBtn" data-bs-dismiss="modal">변경하기</button>
            </div>
        </div>

        <form class="d-none">
            <input type="file" accept="image/*" name="imgs">
        </form>
    </div>
</div>

<!-- 프로필 수정 -->
<div class="modal fade" id="profileModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="profileModalContent">

            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel">프로필</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
            </div>
            <div class="container-center">
                <div class="profile_img circleimg h150 w150 pointer" data-bs-toggle="modal" data-bs-target="#profileImgModal">
                    <img src="<?= getProfileImg() ?>" alt="프로필이미지" id="modProfileImg">
                </div>
            </div>
            <div class="modal-body">
                <form action="profileUpd" method="post">
                    <input type="file" accept="image/*" name="imgs" multiple="" class="d-none">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">이름</label>
                        <input type="text" class="form-control" id="recipient-name" name="nm" value="<?= $this->data->nm ?>">
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">사용자 이름</label>
                        <input type="text" class="form-control" id="message-text" name="email" value="<?= $this->data->email ?>">
                    </div>
                    <div class="mb-3">
                        <label for="intro" class="col-form-label">소개</label>
                        <textarea class="form-control" id="intro" name="cmt"><?= $this->data->cmt ?></textarea>
                    </div>

                    <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
                        <button type="submit" class="btn btn-primary profileUpd">프로필 수정</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>