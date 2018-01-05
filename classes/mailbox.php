<?php

/**
 * Class RESTAPI_CLASS_Mailbox
 * Handle mailbox actions.
 *
 * @author Amin Keshavarz <amin@keshavarz.pro>
 */
class RESTAPI_CLASS_Mailbox
{
    public static function sendMessage($userId, $opponentId, $subject, $message, $files = array())
    {
        $conversationService = MAILBOX_BOL_ConversationService::getInstance();
        $checkResult = $conversationService->checkUser($userId, $opponentId);

        if ($checkResult['isSuspended']) {
            return array('result' => false, 'error' => $checkResult['suspendReasonMessage']);
        }

//        $message = UTIL_HtmlTag::stripTags(UTIL_HtmlTag::stripJs($message));
        $message = UTIL_HtmlTag::stripJs($message);
//        $message = nl2br($message);

        $sentence = $message;
        $event = OW::getEventManager()->trigger(new OW_Event(IISEventManager::PARTIAL_HALF_SPACE_CODE_DISPLAY_CORRECTION, array('sentence' => $sentence)));
        if (isset($event->getData()['correctedSentence'])) {
            $sentence = $event->getData()['correctedSentence'];
            $sentenceCorrected = true;
        }
        $event = OW::getEventManager()->trigger(new OW_Event(IISEventManager::PARTIAL_SPACE_CODE_DISPLAY_CORRECTION, array('sentence' => $sentence)));
        if (isset($event->getData()['correctedSentence'])) {
            $sentence = $event->getData()['correctedSentence'];
            $sentenceCorrected = true;
        }
        if ($sentenceCorrected) {
            $message = $sentence;
        }
        $event = new OW_Event('mailbox.before_create_conversation', array(
            'senderId' => $userId,
            'recipientId' => $opponentId,
            'message' => $message,
            'subject' => $subject
        ), array('result' => true, 'error' => '', 'message' => $message, 'subject' => $subject));
        OW::getEventManager()->trigger($event);

        $data = $event->getData();

        if (empty($data['result'])) {
            return array('result' => 'permission_denied', 'message' => $data['error']);
        }

        if (!trim(strip_tags($data['subject']))) {
            return array('result' => false, 'error' => OW::getLanguage()->text('mailbox', 'subject_is_required'));
        }

        $subject = $data['subject'];
        $message = $data['message'];

        $conversation = $conversationService->createConversation($userId, $opponentId, $subject, $message);
        $messageDto = $conversationService->getLastMessage($conversation->id);

        if (!empty($files)) {
            $conversationService->addMessageAttachments($messageDto->id, $files);
        }

        BOL_AuthorizationService::getInstance()->trackAction('mailbox', 'send_message');

        $conversationService->resetUserLastData($userId);
        $conversationService->resetUserLastData($opponentId);

        return array('result' => true, 'lastMessageTimestamp' => $messageDto->timeStamp);
    }
}