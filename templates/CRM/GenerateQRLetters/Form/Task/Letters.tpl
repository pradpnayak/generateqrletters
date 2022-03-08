<div class="crm-form-block crm-block crm-contact-task-pdf-form-block">
  {if $single eq false}
      <div class="messages status no-popup">{include file="CRM/Contact/Form/Task.tpl"}</div>
  {/if}
  <table class="form-layout-compressed">
    {section name='i' start=1 loop=$contributionPages}
    {assign var='blockId' value=$smarty.section.i.index}
      <tr>
        <td class="label-left">{$form.contribution_page_ids.$blockId.label}</td>
        <td>{$form.contribution_page_ids.$blockId.html}</td>
      </tr>
    {/section}
    <tr>
      <td class="label-left">
        {$form.template.label}
        {help id="template" title=$form.template.label file="CRM/Contact/Form/Task/PDFLetterCommon.hlp"}
      </td>
      <td>{$form.template.html}</td>
    </tr>
  </table>
  <div class="crm-accordion-wrapper crm-html_email-accordion ">
    <div class="crm-accordion-header">
        {$form.html_message.label}
    </div><!-- /.crm-accordion-header -->
    <div class="crm-accordion-body">
      <div class="helpIcon" id="helphtml">
        <input class="crm-token-selector big" data-field="html_message" />
        {help id="id-token-html" tplFile=$tplFile isAdmin=$isAdmin file="CRM/Contact/Form/Task/Email.hlp"}
      </div>
      <div class="clear"></div>
      <div class='html'>{$form.html_message.html}<br /></div>
      <div id="editMessageDetails"></div>
    </div><!-- /.crm-accordion-body -->
  </div><!-- /.crm-accordion-wrapper -->

  {include file="CRM/Mailing/Form/InsertTokens.tpl"}
  <div class="crm-submit-buttons">{include file="CRM/common/formButtons.tpl" location="bottom"}</div>
</div>
