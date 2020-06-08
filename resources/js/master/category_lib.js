function WorkDivision_lib(){}

WorkDivision_lib.prototype = {

    AJAX_URL : '/master/work_division/ajax/',

    SEL_WORK_DIVISION_NAME_INPUT_ADD : '._js_work_division_name_input_add',
    SEL_WORK_DIVISION_NAME_INPUT_EDIT : '._js_work_division_name_input_edit',
    SEL_WORK_DIVISION_ID_INPUT_EDIT : '._js_work_division_id_input_edit',
    SEL_WORK_DIVISION_LIST : '._js_work_division_list',
    SEL_INPUT_TEST : '._js_input_test',
    SEL_UPLOAD_CSV : '._js_work_division_upload_csv',
    SEL_UPLOAD_CSV_PREVIEW_MODAL_CONTENT : '._js_work_division_upload_modal_content',
    SEL_UPLOAD_WORK_DIVISION_ROW : '._js_upload_work_division_row',
    SEL_UPLOAD_WORK_DIVISION_ID : '._js_upload_work_division_id',
    SEL_UPLOAD_WORK_DIVISION_NAME : '._js_upload_work_division_name',

    UPLOAD_PREVIEW_MODAL : '#upload-preview-modal',

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
     * CSVアップロードプレビュー表示
     *
     * @param {object} pObj ボタンオブジェクト
     */
    CsvUpload: function( pObj)
    {
        const aUrl = this.AJAX_URL + 'upload',
        formData = new FormData( $( this.SEL_UPLOAD_CSV ).get(0) ),
        aThis = this;

        Common_Lib.ShowWait();
        const aAjaxObj = Common_Lib.FileRequest( aUrl, formData,
            function ( pData )
            {
                if ( pData['error'] )
                {
                    alert(pData['error']);
                    return;
                }
                $( aThis.SEL_UPLOAD_CSV_PREVIEW_MODAL_CONTENT ).html( pData );
                Common_Lib.OpenModal( aThis.UPLOAD_PREVIEW_MODAL );
            });
        if ( aAjaxObj )
        {
            Common_Lib.HideWait();
        }
    },

    /**
     * CSVアップロード保存
     *
     * @param {object} pObj ボタンオブジェクト
     */
    CsvSave: function( pObj)
    {
        /* 上書き更新します。よろしいですか? */
        if ( !confirm('\u4e0a\u66f8\u304d\u66f4\u65b0\u3057\u307e\u3059\u3002\u3088\u308d\u3057\u3044\u3067\u3059\u304b?') )
        {
            return;
        }

        const aThis = this,
        aUrl = this.AJAX_URL + 'upload/save',
        aData = [],
        aRowObj = $( this.SEL_UPLOAD_WORK_DIVISION_ROW );

        aRowObj.each(function (index, value) {
            const aRow = {};
            aRow['id'] = $(this).find( aThis.SEL_UPLOAD_WORK_DIVISION_ID ).val();
            aRow['name'] = $(this).find( aThis.SEL_UPLOAD_WORK_DIVISION_NAME ).val();
            aData.push(aRow);
        });

        Common_Lib.ShowWait();
        const aAjaxObj = Common_Lib.Request( aUrl, aData,
            function ( pData )
            {
                if ( pData['error'] )
                {
                    alert(pData['error']);
                }
                $( aThis.SEL_WORK_DIVISION_LIST ) .html( pData );
                Common_Lib.HideModal( aThis.UPLOAD_PREVIEW_MODAL );
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
