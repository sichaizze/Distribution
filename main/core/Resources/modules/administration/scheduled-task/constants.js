import {t} from '#/main/core/translation'

export const VIEW_MANAGEMENT = 'management_view'
export const VIEW_MAIL_FORM = 'mail_form_view'
export const VIEW_MESSAGE_FORM = 'message_form_view'

export const taskTypes = [
  {
    type: 'mail',
    label: t('mail'),
    icon: 'fa fa-at'
  },
  {
    type: 'message',
    label: t('message'),
    icon: 'fa fa-envelope'
  }
]

export const constants = {
  taskTypes
}
