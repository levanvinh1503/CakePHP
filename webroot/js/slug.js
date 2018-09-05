/**
 * Convert string to url
 *
 * @param string titleInput
 *
 * @return string
 */
function ChangeToSlug(titleInput)
{
    var slugUrl;
    /*All alphabetic characters are converted to lowercase*/
    slugUrl = titleInput.toLowerCase();
    /*Change character with unsigned*/
    slugUrl = slugUrl.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slugUrl = slugUrl.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slugUrl = slugUrl.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slugUrl = slugUrl.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slugUrl = slugUrl.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slugUrl = slugUrl.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    slugUrl = slugUrl.replace(/đ/gi, 'd');
    /*Delete special characters*/
    slugUrl = slugUrl.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    /*Change the whitespace to a dash character*/
    slugUrl = slugUrl.replace(/ /gi, "-");
    /*Converts multiple consecutive dashes into a dash character*/
    slugUrl = slugUrl.replace(/\-\-\-\-\-/gi, '-');
    slugUrl = slugUrl.replace(/\-\-\-\-/gi, '-');
    slugUrl = slugUrl.replace(/\-\-\-/gi, '-');
    slugUrl = slugUrl.replace(/\-\-/gi, '-');
    /*Remove hyphens at the beginning and end*/
    slugUrl = '@' + slugUrl + '@';
    slugUrl = slugUrl.replace(/\@\-|\-\@|\@/gi, '');

    return slugUrl;
}