function WorkDivision_lib(){}

WorkDivision_lib.prototype = {

    AJAX_URL : '/master/work_division/ajax/',

    SEL_WORK_DIVISION_NAME_INPUT_ADD : '._js_work_division_name_input_add',
    SEL_WORK_DIVISION_NAME_INPUT_EDIT : '._js_work_division_name_input_edit',
    SEL_WORK_DIVISION_ID_INPUT_EDIT : '._js_work_division_id_input_edit',
    SEL_WORK_DIVISION_LIST : '._js_work_division_list',
    SEL_INPUT_TEST : '._js_input_test',

    /**
     * 新規登録
     *
     * @param {object} pObj ボタンオブジェクト
     */
    Submit : function( pObj )
    {
        const aWorkDivisionName = $(this.SEL_WORK_DIVISION_NAME_INPUT_ADD).val();
        if ( !aWorkDivisionName.trim() )
        {
            /** 勤怠区分名称を入力してください。*/
            alert('\u52e4\u6020\u533a\u5206\u540d\u79f0\u3092\u5165\u529b\u3057\u3066\u304f\u3060\u3055\u3044\u3002');
            return;
        }
        const aPost = {
            'work_division_name' : aWorkDivisionName,
        };

        this._UpdateWorkDivision( pObj, aPost, 'submit');
    },

    /**
     * 編集
     *
     * @param {object} pObj ボタンオブジェクト
     */
    ReSubmit : function( pObj )
    {
        const aWorkDivisionName = $(this.SEL_WORK_DIVISION_NAME_INPUT_EDIT).val();
        const aWorkDivisionId = $(this.SEL_WORK_DIVISION_ID_INPUT_EDIT).val();
        if ( !aWorkDivisionName.trim() )
        {
            /** 勤怠区分名称を入力してください。*/
            alert('\u52e4\u6020\u533a\u5206\u540d\u79f0\u3092\u5165\u529b\u3057\u3066\u304f\u3060\u3055\u3044\u3002');
            return;
        }
        const aPost = {
            'work_division_name' : aWorkDivisionName,
            'id' : aWorkDivisionId
        };

        this._UpdateWorkDivision( pObj, aPost, 'resubmit');
    },

    /**
     * 勤怠区分を更新する
     *
     * @param {object} pObj ボタンオブジェクト
     * @param {object} pPost 送信データ
     * @param {string} pCmd 登録区分
     */
    _UpdateWorkDivision : function( pObj, pPost, pCmd )
    {
        const aUrl = this.AJAX_URL + pCmd,
              aWorkDivisionList = $(this.SEL_WORK_DIVISION_LIST),
              aWorkDivisionName = $(this.SEL_WORK_DIVISION_NAME_INPUT_ADD);
        Common_Lib.ShowWait();
        const aAjaxObj = Common_Lib.Request( aUrl, pPost,
            function ( pData )
            {
                if ( pData['error'] )
                {
                    alert(pData['error']);
                    return;
                }
                aWorkDivisionList.html( pData );
                aWorkDivisionName.val('');
                Common_Lib.nowModal.fadeOut(Common_Lib.DISP_MODAL_SPEED);
            });
        if ( aAjaxObj )
        {
            Common_Lib.HideWait();
        }
    },

    /**
     * 削除
     *
     * @param {object} pObj ボタンオブジェクト
     * @param {int} pId 勤怠区分ID
     */
    Delete: function( pObj, pId )
    {
        /** 本当に削除してもよろしいですか? */
        if( !confirm('\u672c\u5f53\u306b\u524a\u9664\u3057\u3066\u3088\u308d\u3057\u3044\u3067\u3059\u304b?') )
        {
            return;
        }

        const aPost = {
            'id' : [pId],
        };

        const aUrl = this.AJAX_URL + 'delete',
        aWorkDivisionList = $(this.SEL_WORK_DIVISION_LIST);

        Common_Lib.ShowWait();
        const aAjaxObj = Common_Lib.Request( aUrl, aPost,
            function ( pData )
            {
                if ( pData['error'] )
                {
                    alert(pData['error']);
                    return;
                }
                aWorkDivisionList.html( pData );
                Common_Lib.nowModal.fadeOut(Common_Lib.DISP_MODAL_SPEED);
            });
        if ( aAjaxObj )
        {
            Common_Lib.HideWait();
        }
    },

    /**
     * 編集モーダルオープン時に内容を復元
     * @param pObj
     * @constructor
     */
    SetEditModalValue : function( pObj )
    {
        $(this.SEL_WORK_DIVISION_NAME_INPUT_EDIT).val( $(pObj).data('division-name'));
        $(this.SEL_WORK_DIVISION_ID_INPUT_EDIT).val( $(pObj).data('id'));
    },
};

$(function () {
    window.WorkDivision_lib = new WorkDivision_lib();
});
