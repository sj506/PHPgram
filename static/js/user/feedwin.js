if (feedObj) {
  const url = new URL(location.href);
  feedObj.iuser = parseInt(url.searchParams.get('iuser'));
  feedObj.getFeedUrl = '/user/feed';
  feedObj.getFeedList();
}
// function getFeedList() {
//     if (!feedObj) {
//         return;
//     }
//     feedObj.showLoading();
//     const param = {
//         page: feedObj.currentPage++,
//         iuser: url.searchParams.get('iuser'),
//     };
//     fetch('/user/feed' + encodeQueryString(param))
//         .then((res) => res.json())
//         .then((list) => {
//             feedObj.makeFeedList(list);
//         })
//         .catch((e) => {
//             console.error(e);
//             feedObj.hideLoading();
//         });
// }
// getFeedList();

(function () {
  const gData = document.querySelector('#gData');

  const btnFollow = document.querySelector('#btnFollow');
  const spanCntFollower = document.querySelector('.follower');

  if (btnFollow) {
    btnFollow.addEventListener('click', function () {
      const param = {
        toiuser: parseInt(gData.dataset.toiuser),
      };
      console.log(param);
      const follow = btnFollow.dataset.follow;
      console.log('follow : ' + follow);
      const followUrl = '/user/follow';
      switch (follow) {
        case '1': //팔로우 취소
          fetch(followUrl + encodeQueryString(param), { method: 'DELETE' })
            .then((res) => res.json())
            .then((res) => {
              console.log(res);
              if (res.result) {
                btnFollow.dataset.follow = '0';
                btnFollow.classList.remove('btn-outline-secondary');
                btnFollow.classList.add('btn-primary');
                btnFollow.dataset.youme === '1' ? (btnFollow.innerText = '맞팔로우 하기') : (btnFollow.innerText = '팔로우');

                spanCntFollower.innerText = parseInt(spanCntFollower.innerText) - 1;
              }
            });
          break;
        case '0': //팔로우 등록
          fetch(followUrl, {
            method: 'POST',
            body: JSON.stringify(param),
          })
            .then((res) => res.json())
            .then((res) => {
              console.log(res);
              if (res.result) {
                btnFollow.dataset.follow = '1';
                btnFollow.classList.remove('btn-primary');
                btnFollow.classList.add('btn-outline-secondary');
                btnFollow.innerText = '팔로우취소';

                spanCntFollower.innerText = parseInt(spanCntFollower.innerText) + 1;
              }
            });
          break;
      }
    });
  }

  // 이미지 업로드----------------------------------------------------------
  const imgUploadBtn = document.querySelector('#currentProfileImg');
  const btnDelCurrentProfilePic = document.querySelector('#btnDelCurrentProfilePic');

  const btnClose = document.querySelector('#btnModalClose');

  const myfeedmodal = document.querySelector('#changeProfileImgModal');
  const updprofileImg = myfeedmodal.querySelector('input');
  const frmElem = myfeedmodal.querySelector('form');
  const changeBtn = document.querySelector('#changeBtn');

  imgUploadBtn.addEventListener('click', () => {
    if (gData.dataset.loginiuser !== gData.dataset.toiuser) {
      console.log(gData);
      console.log(gData.dataset.loginiuser);
      console.log(gData.dataset.toiuser);
      alert('돌아가~');
      return;
    }
    updprofileImg.click();
  });

  updprofileImg.addEventListener('change', (e) => {
    const files = frmElem.imgs.files[0];
    const fData = new FormData();
    fData.append('imgs', files);
    console.log(files);
    if (e.target.files.length > 0) {
      const imgSource = e.target.files[0];
      const reader = new FileReader();
      reader.readAsDataURL(imgSource);
      reader.onload = function () {
        imgUploadBtn.src = reader.result;
      };

      changeBtn.addEventListener('click', function () {
        fetch('/user/profile', {
          method: 'POST',
          body: fData,
        })
          .then((res) => res.json())
          .then((res) => {
            console.log(res);
            const profileImgList = document.querySelectorAll('.profileimg');
            profileImgList.forEach((item) => {
              item.src = `/static/img/profile/${gData.dataset.loginiuser}/${res.fileNm}`;
            });
          });
        btnClose.click();
        btnDelCurrentProfilePic.classList.remove('d-none');
      });
    }
  });

  btnDelCurrentProfilePic.addEventListener('click', () => {
    fetch('/user/profile', {
      method: 'DELETE',
    })
      .then((res) => res.json())
      .then((res) => {
        const profileImgList = document.querySelectorAll('.profileimg');
        profileImgList.forEach((item) => {
          item.src = '/static/img/profile/defaultProfileImg_100.png';
        });
        if (res) {
          btnClose.click();
          btnDelCurrentProfilePic.classList.add('d-none');
        }
      });
  });
})();
