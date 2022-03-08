<div class="crm-block crm-form-block">
  {* HEADER *}
  <div class="crm-submit-buttons">
    {include file="CRM/common/formButtons.tpl" location="top"}
  </div>

  {foreach from=$elementNames item=elementName}
    <div class="crm-section">
      <div class="label">{$form.generateqrletters.$elementName.label}</div>
      <div class="content">
        {$form.generateqrletters.$elementName.html}
        {if $help.$elementName}
          </br>
          <span class="description">{$help.$elementName}<span>
        {/if}
      </div>
      <div class="clear"></div>
    </div>
  {/foreach}

  {* FOOTER *}
  <div class="crm-submit-buttons">
    {include file="CRM/common/formButtons.tpl" location="bottom"}
  </div>
</div>
