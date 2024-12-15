{include file='header.tpl' showWhiteBack=true}

<h2 class="page-header">
    <a href="{router page='admin'}">{$aLang.admin_header}</a>
    <span>&raquo;</span>
    {$aLang.plugin.cleaner.title_cleaner}
</h2>

<div class="note-cleaner">{$aLang.plugin.cleaner.note_cleaner}</div>

{literal}
    <script language="JavaScript" type="text/javascript">
        jQuery(document).ready(function($){
            $('#cleaner-loader').jqm({modal: true});
        });
        function Cleaner() {
            $('#cleaner-loader').jqmShow();
            ls.ajaxSubmit(aRouter['admin'] + 'cleaner-go/', $('#cleaner-form'), function (result) {
                $('#cleaner-loader').jqmHide();
                if (result.bStateError) {
                    ls.msg.error(null, result.sMsg);
                } else {
                    ls.msg.notice(null, result.sMsg);
                }
            });
        }
    </script>
{/literal}
<br/>



<form action="" method="POST" id="cleaner-form" enctype="multipart/form-data" onsubmit="return false;">
    <div id="cleaner-loader" class="modal">
        <img src="{$sTWCleaner}/images/loader.png" >
    </div>
    <p>
        <label>
            <input type="checkbox" name="images" id="clean_images" value="1" class="" /> - {$aLang.plugin.cleaner.clean_image}
        </label>
    </p>

    <p>
        <label>
            <input type="checkbox" name="comments" id="clean_comments" value="1" checked class="" /> - {$aLang.plugin.cleaner.clean_comments}
        </label>
    </p>

    <p>
        <label>
            <input type="checkbox" name="counters" id="clean_counters" value="1" checked class="" /> - {$aLang.plugin.cleaner.clean_counters}
        </label>
    </p>

    <p>
        <label>
            <input type="checkbox" name="relations" id="clean_relations" value="1" checked class="" /> - {$aLang.plugin.cleaner.clean_relation}
        </label>
    </p>

    <div style="text-align: center">
        <input type="button" value="{$aLang.plugin.cleaner.cleaner_button}" onclick="Cleaner();"
               class="button button-primary" />
    </div>

</form>

{include file='footer.tpl'}
