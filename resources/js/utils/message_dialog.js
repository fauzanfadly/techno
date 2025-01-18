import { ref } from "vue"


export const _dialog = ref(false);
export const _message = ref('');
export const _description = ref('');
export const _icon = ref('');
export const _iconColor = ref('');
export const _actionButtons = ref([]);

export function openMessage({
    message,
    description = "",
    icon = "",
    iconColor = "primary",
    dialog = true,
    actionButtons = [],
}) {
    _dialog.value = dialog
    _message.value = message
    _description.value = description
    _icon.value = icon
    _iconColor.value = iconColor
    _actionButtons.value = actionButtons
}