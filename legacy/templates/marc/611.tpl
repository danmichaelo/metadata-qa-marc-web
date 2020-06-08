{assign var="fieldInstances" value=getFields($record, '611')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>meetings</em>:</td>
  <td>
    {foreach $fieldInstances as $field}
      <span class="611">
          {* Personal name *}
          {if isset($field->subfields->a)}
            <i class="fa fa-hashtag" aria-hidden="true" title="meeting name"></i>
            <a href="#" class="record-link" data="611a_SubjectAddedMeetingName_ss">{$field->subfields->a}</a>
          {/if}

          {if isset($field->subfields->b)}
            <span class="numeration" data="611b_SubjectAddedMeetingName_b_ss">{$field->subfields->b}</span>
          {/if}

          {if isset($field->subfields->c)}
            <span class="location" data="611c_SubjectAddedMeetingName_locationOfMeeting_ss">{$field->subfields->c}</span>
          {/if}

          {if isset($field->subfields->d)}
            <span class="dates" data="611d_SubjectAddedMeetingName_dates_ss">{$field->subfields->d}</span>
          {/if}

          {if isset($field->subfields->{'2'})}
            vocabulary: {$field->subfields->{'2'}}</a>
          {/if}

          {* 6500_Topic_authorityRecordControlNumber_ss *}
          {if isset($field->subfields->{'0'})}
            (authority: <a href="#" class="record-link" data="6110">{$field->subfields->{'0'}}</a>)
          {/if}
        </span>
      <br/>
    {/foreach}
  </td>
</tr>
{/if}
