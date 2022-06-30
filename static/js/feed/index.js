(function () {
    const btnNewFeedModal = document.querySelector('#btnNewFeedModal');
    if (btnNewFeedModal) {
        const modal = document.querySelector('#newFeedModal');
        const body = modal.querySelector('#id-modal-body');
        const frmElem = modal.querySelector('form');
        const btnClose = modal.querySelector('.btn-close');
        //이미지 값이 변하면
        frmElem.imgs.addEventListener('change', function (e) {
            console.log(`length: ${e.target.files.length}`);
            if (e.target.files.length > 0) {
                body.innerHTML = `
                    <div>
                        <div class="d-flex flex-md-row">
                            <div class="flex-grow-1 h-full"><img id="id-img" class="w300"></div>
                            <div class="ms-1 w250 d-flex flex-column">                
                                <textarea placeholder="문구 입력..." class="flex-grow-1 p-1"></textarea>
                                <input type="text" placeholder="위치" class="mt-1 p-1">
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="button" class="btn btn-primary">공유하기</button>
                    </div>
                `;
                const imgElem = body.querySelector('#id-img');

                const imgSource = e.target.files[0];
                const reader = new FileReader();
                reader.readAsDataURL(imgSource);
                reader.onload = function () {
                    imgElem.src = reader.result;
                };

                const shareBtnElem = body.querySelector('button');
                shareBtnElem.addEventListener('click', function () {
                    const files = frmElem.imgs.files;

                    const fData = new FormData();
                    for (let i = 0; i < files.length; i++) {
                        fData.append('imgs[]', files[i]);
                    }
                    fData.append('ctnt', body.querySelector('textarea').value);
                    fData.append('location', body.querySelector('input[type=text]').value);

                    location.reload();

                    fetch('/feed/rest', {
                        method: 'post',
                        body: fData,
                    })
                        .then((res) => res.json())
                        .then((myJson) => {
                            console.log(myJson);

                            if (myJson.result) {
                                btnClose.click();
                            }
                        });
                });
            }
        });

        btnNewFeedModal.addEventListener('click', function () {
            const selFromComBtn = document.createElement('button');
            selFromComBtn.type = 'button';
            selFromComBtn.className = 'btn btn-primary';
            selFromComBtn.innerText = '컴퓨터에서 선택';
            selFromComBtn.addEventListener('click', function () {
                frmElem.imgs.click();
            });
            body.innerHTML = null;
            body.appendChild(selFromComBtn);
        });
    }

    function moveToFeedWin(iuser) {
        location.href = `/user/feedwin?iuser=${iuser}`;
    }

    const feedObj = {
        limit: 20,
        itemLength: 0,
        currentPage: 1,
        swiper: null,
        loadingElem: document.querySelector('.loading'),
        containerElem: document.querySelector('#item_container'),

        lightbox: document.querySelector('#lightbox'),
        lightboxImage: document.querySelector('#lightboxImage'),

        getFeedList: function () {
            this.showLoading();
            const param = {
                page: this.currentPage++,
            };
            fetch('/feed/rest' + encodeQueryString(param))
                .then((res) => res.json())
                .then((list) => {
                    this.makeFeedList(list);
                })
                .catch((e) => {
                    console.error(e);
                    this.hideLoading();
                });
        },
        makeFeedList: function (list) {
            if (list.length !== 0) {
                list.forEach((item) => {
                    const divItem = this.makeFeedItem(item);
                    this.containerElem.appendChild(divItem);
                });
            }
            this.hideLoading();

            if (this.swiper !== null) {
                this.swiper = null;
            }
            this.swiper = new Swiper('.swiper', {
                pagination: {
                    el: '.swiper-pagination',
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                allowTouchMove: false,
                directionL: 'horizontal',
                loop: false,
            });
        },
        makeFeedItem: function (item) {
            console.log(item);
            const divContainer = document.createElement('div');
            divContainer.className = 'item mt-3 mb-3';

            const divTop = document.createElement('div');
            divContainer.appendChild(divTop);

            const regDtInfo = getDateTimeInfo(item.regdt);
            divTop.className = 'd-flex flex-row ps-3 pe-3';
            const writerImg = `<img src='/static/img/profile/${item.iuser}/${item.mainimg}' 
                onerror='this.error=null;this.src="/static/img/profile/defaultProfileImg_100.png"'>`;

            divTop.innerHTML = `
                <div class="d-flex flex-column justify-content-center">
                    <div class="circleimg h30 w30 pointer feedWin">${writerImg}</div>
                </div>
                <div class="p-3 flex-grow-1">
                        <div>
                            <span class="pointer fedWin" onclick="moveToFeedWin(${item.iuser});">
                                ${item.writer}
                            </span>
                        - ${regDtInfo}
                        </div>
                    <div>${item.location === null ? '' : item.location}</div>
                </div>
            `;

            const spanProfile = divTop.querySelectorAll('.feedWin');
            spanProfile.forEach((el) => {
                el.addEventListener('click', () => {
                    moveToFeedWin(item.iuser);
                });
            });

            const divImgSwiper = document.createElement('div');
            divContainer.appendChild(divImgSwiper);
            divImgSwiper.className = 'swiper item_img';
            divImgSwiper.innerHTML = `
            <div class="swiper-wrapper align-items-center"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
            `;
            const divSwiperWrapper = divImgSwiper.querySelector('.swiper-wrapper');

            //TODO : imgList forEach 돌릴 예정
            item.imgList.forEach(function (imgObj) {
                const divSwiperSlide = document.createElement('div');
                divSwiperWrapper.appendChild(divSwiperSlide);
                divSwiperSlide.classList.add('swiper-slide');

                const img = document.createElement('img');
                divSwiperSlide.appendChild(img);
                img.className = 'w100p_mw614 pointer';
                img.src = `/static/img/feed/${item.ifeed}/${imgObj.img}`;
                img.addEventListener('click', () => {
                    const imgBox = document.createElement('div');
                    imgBox.classList = 'modal modal-img d-flex align-items-center';
                    imgBox.tabIndex = '2';
                    imgBox.innerHTML = `
                    <div class="modal-dialog">
                    <div class="modal-content img-modal-content">
                    <img src="${img.src}">
                    </div>
                    </div>`;
                    console.log(img);
                    imgBox.classList.add('d-flex');
                    const main = document.querySelector('main');
                    main.appendChild(imgBox);
                    imgBox.addEventListener('click', () => {
                        imgBox.remove();
                    });
                });
            });

            const divBtns = document.createElement('div');
            divContainer.appendChild(divBtns);
            divBtns.className = 'favCont p-2 d-flex flex-row';

            const heartIcon = document.createElement('i');
            divBtns.appendChild(heartIcon);
            heartIcon.className = 'fa-heart pointer rem1_2 me-3';
            heartIcon.classList.add(item.isFav === 1 ? 'fas' : 'far');

            heartIcon.addEventListener('click', (e) => {
                console.log(item.isFav);
                if (item.isFav === 0) {
                    heartIcon.classList.add('fas');
                    heartIcon.classList.remove('fav');
                } else if (item.isFav === 1) {
                    heartIcon.classList.add('fav');
                    heartIcon.classList.remove('fas');
                }
                let method = 'POST';

                if (item.isFav === 1) {
                    method = 'DELETE';
                }

                fetch(`/feed/fav/${item.ifeed}`, {
                    method: method,
                })
                    .then((res) => res.json())
                    .then((res) => {
                        console.log(res);
                        if (res.result) {
                            item.isFav = 1 - item.isFav;
                        } else {
                            heartIcon.classList.add(item.isFav === 0 ? 'fas' : 'far');
                            alert('좋아요를 할 수 없어요');
                        }
                    });
            });

            const divDm = document.createElement('div');
            divBtns.appendChild(divDm);
            divDm.className = 'pointer';
            divDm.innerHTML = `<svg aria-label="다이렉트 메시지" class="_8-yf5 " color="#262626" fill="#262626" height="24" role="img" viewBox="0 0 24 24" width="24"><line fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="2" x1="22" x2="9.218" y1="3" y2="10.083"></line><polygon fill="none" points="11.698 20.334 22 3.001 2 3.001 9.218 10.084 11.698 20.334" stroke="currentColor" stroke-linejoin="round" stroke-width="2"></polygon></svg>`;

            const divFav = document.createElement('div');
            divContainer.appendChild(divFav);
            divFav.className = 'p-2 d-none';
            const spanFavCnt = document.createElement('span');
            divFav.appendChild(spanFavCnt);
            spanFavCnt.className = 'bold';
            spanFavCnt.innerHTML = `좋아요 ${item.favCnt}개`;

            if (item.favCnt > 0) {
                divFav.classList.remove('d-none');
            }

            if (item.ctnt !== null) {
                const divCtnt = document.createElement('div');
                divContainer.appendChild(divCtnt);
                divCtnt.innerText = item.ctnt;
                divCtnt.className = 'itemCtnt p-3';
            }

            const divCmt = document.createElement('div');
            divContainer.appendChild(divCmt);
            const divCmtList = document.createElement('div');
            divCmt.appendChild(divCmtList);
            const divCmtForm = document.createElement('div');
            divCmt.appendChild(divCmtForm);

            divCmtForm.innerHTML = `
            <input type='text' class="flex-grow-1 my_input back_color" placeholder="댓글을 입력하세요...">
            <button type="button" class="btn btn-outline-primary">등록</button>
            `;

            const insMod = document.createElement('div');
            insMod.className = 'd-flex flex-row justify-content-end align-items-center';
            insMod.innerHTML = `
                        <div class="dropdown p-2">
                            <a href="#" role="button" id="navDropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false" class="header_profile">
                            <i class="fa-solid fa-ellipsis pointer rem1_2 me-3 far">...</i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navDropdownMenuLink">
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/feed/rest">수정</a></li>
                                <li><a class="dropdown-item" href="/feed/rest">삭제</a></li>
                            </ul>
                        </div>
            `;

            divBtns.appendChild(insMod);

            return divContainer;
        },

        showLoading: function () {
            this.loadingElem.classList.remove('d-none');
        },
        hideLoading: function () {
            this.loadingElem.classList.add('d-none');
        },
    };

    feedObj.getFeedList();
})();
