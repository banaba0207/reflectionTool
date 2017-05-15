$(function($) {
    const ENTER_KEY_CODE = 13;
    $("body").keypress(function(e) {
        // エンターでaddTaskをsubmit
        if (e.keyCode === ENTER_KEY_CODE) {
            // shiftキー同時押しの場合、割り込みタスクとして処理
            if (e.shiftKey) {
                $('#addTask [name=isCutInTask]').val(1);
            }

            $("#addTask").submit();
            return false;
        }
    });
});
