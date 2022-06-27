(function () {
    const btnNewFeedModal = document.querySelector('#btnNewFeedModal');
    if (btnNewFeedModal) {
        // 문서에서 이 주소값이 있는지 확인
        const modal = document.querySelector('#newFeedModal');
        const body = modal.querySelector('#id-modal-body');
        const frmElem = modal.querySelector('form');

        //이미지 값이 변하면
        frmElem.imgs.addEventListener('change', function (e) {
            // form 태그는 자식에게 접근할 때 . 으로도 가능
            if (e.target.files.length > 0) {
                // 이미지를 1개 이상 선택했다
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
                        fData.append('imgs', files[i]);
                    }
                    fData.append('ctnt', body.querySelector('textarea').value);
                    fData.append('location', body.querySelector('input[type=text]').value);

                    fetch('/feed/reg', {
                        method: 'post',
                        body: fData,
                    })
                        .then((res) => res.json())
                        .then((myJson) => {
                            const closeBtn = modal.querySelector('.btn-close');
                            closeBtn.click();

                            if (feedObj && myJson.result) {
                                feedObj.refreshList();
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
})();
