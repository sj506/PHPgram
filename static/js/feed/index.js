if (feedObj) {
    feedObj.getFeedUrl = '/feed/rest';
    feedObj.getFeedList();
    feedObj.setScrollInfinity();
}

//     feedObj.showLoading();
//     const param = {
//         page: feedObj.currentPage++,
//     };
//     fetch('/feed/rest' + encodeQueryString(param))
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
