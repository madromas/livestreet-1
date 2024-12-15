{if $oConfig->GetValue('plugin.feedback.system.button_name')}
	{assign var="sFeedbackButtonTitle" value=$oConfig->GetValue('plugin.feedback.system.button_name')}
{else}
	{assign var="sFeedbackButtonTitle" value=$aLang.plugin.feedback.button}
{/if}

