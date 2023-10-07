<?php

namespace App\Constants;

class MessageConstant
{
    // Auth
    public static string $LOGIN_SUCCESS = "Login success!";
    public static string $LOGIN_FAILED = "Login failed!";
    public static string $REGISTER_SUCCESS = "Register success!";
    public static string $REGISTER_FAILED = "Register failed!";
    public static string $MEMBER_NOT_EXIST = "Member not exist";
    public static string $MEMBER_VERIFIED_EMAIL = "Member verified email";
    public static string $OTP_IS_STILL_USABLE = "Otp is still usable";
    public static string $SEND_OTP_SUCCESS = "Send otp success";
    public static string $SEND_OTP_FAILED = "Send otp failed";
    public static string $EMAIL_VERIFICATION_SUCCESS = "Email verification success";
    public static string $EMAIL_VERIFICATION_FAILED = "Email verification failed";

    // User
    public static string $GET_LIST_USERS_SUCCESS = "Get all users success!";
    public static string $GET_LIST_USERS_FAILED = "Get all users failed!";
    public static string $GET_DETAIL_USER_SUCCESS = "Get user by id success!";
    public static string $GET_DETAIL_USER_FAILED = "Get user by id failed!";
    public static string $CREATE_USER_SUCCESS = "Create user success!";
    public static string $CREATE_USER_FAILED = "Create user failed!";
    public static string $UPDATE_USER_SUCCESS = "Update user success!";
    public static string $UPDATE_USER_FAILED = "Update user failed!";
    public static string $DELETE_USER_SUCCESS = "Delete user success!";
    public static string $DELETE_USER_FAILED = "Delete user failed!";
    public static string $RESET_PASSWORD_SUCCESS = "Reset password success!";
    public static string $RESET_PASSWORD_FAILDED = "Reset password failed!";
    public static string $LOCK_USER_SUCCESS = "Lock user success!";
    public static string $LOCK_USER_FAILED = "Lock user failed!";

    // Friend
    public static string $GET_LIST_FRIENDS_SUCCESS = "Get all friends success!";
    public static string $GET_LIST_FRIENDS_FAILED = "Get all friends failed!";
    public static string $GET_DETAIL_FRIEND_SUCCESS = "Get friend success!";
    public static string $GET_DETAIL_FRIEND_FAILED = "Get friend failed!";
    public static string $SEND_FRIEND_INVATION_SUCCESS = "Send friend invation success!";
    public static string $SEND_FRIEND_INVATION_FAILED = "Send friends invation failed!";
    public static string $ACCEPT_FRIEND_INVATION_SUCCESS = "Accept friend invation success!";
    public static string $ACCEPT_FRIEND_INVATION_FAILED = "Accept friends invation failed!";
    public static string $REJECT_FRIEND_INVATION_SUCCESS = "Reject friend invation success!";
    public static string $REJECT_FRIEND_INVATION_FAILED = "Reject friends invation failed!";
    public static string $DELETE_FRIEND_INVATION_SUCCESS = "Delete friend invation success!";
    public static string $DELETE_FRIEND_INVATION_FAILED = "Delete friends invation failed!";
    public static string $CANCEL_FRIEND_INVATION_SUCCESS = "Cancel friend invation success!";
    public static string $CANCEL_FRIEND_INVATION_FAILED = "Cancel friends invation failed!";

    // Conversation
    public static string $GET_LIST_CONVERSATION_SUCCESS = "Get all conversation success!";
    public static string $GET_LIST_CONVERSATION_FAILED = "Get all conversation failed!";
    public static string $GET_DETAIL_CONVERSATION_SUCCESS = "Get conversation success!";
    public static string $GET_DETAIL_CONVERSATION_FAILED = "Get conversation failed!";
    public static string $GET_DETAIL_CONVERSATION_PRIVATE_SUCCESS = "Get conversation private success!";
    public static string $GET_DETAIL_CONVERSATION_PRIVATE_FAILED = "Get conversation private failed!";
    public static string $CREATE_CONVERSATION_SUCCESS = "Create conversation success!";
    public static string $CREATE_CONVERSATION_FAILED = "Create conversation failed!";
    public static string $GET_ALL_MESSAGES_CONVERSATION_SUCCESS = "Get all message in conversation success!";
    public static string $GET_ALL_MESSAGES_CONVERSATION_FAILED = "Get all message in conversation failed!";
    public static string $UPDATE_CONVERSATION_SUCCESS = "Update conversation success!";
    public static string $UPDATE_CONVERSATION_FAILED = "Update conversation failed!";
    public static string $ADD_MEMBER_CONVERSATION_SUCCESS = "Add member for conversation success!";
    public static string $ADD_MEMBER_CONVERSATION_FAILED = "Add member for conversation failed!";
    public static string $KICK_MEMBER_CONVERSATION_SUCCESS = "Kick member for conversation success!";
    public static string $KICK_MEMBER_CONVERSATION_FAILED = "Kick member for conversation failed!";
    public static string $LEAVE_CONVERSATION_SUCCESS = "Leave conversation success!";
    public static string $LEAVE_CONVERSATION_FAILED = "Leave conversation failed!";
    public static string $DELETE_CONVERSATION_SUCCESS = "Delete conversation success!";
    public static string $DELETE_CONVERSATION_FAILED = "Delete conversation failed!";

    // Message
    public static string $CREATE_MESSAGE_SUCCESS = "Create message success!";
    public static string $CREATE_MESSAGE_FAILED = "Create message failed!";
    public static string $SEEN_MESSAGE_SUCCESS = "Seen message success!";
    public static string $SEEN_MESSAGE_FAILED = "Seen message failed!";
    public static string $REMOVE_MESSAGE_SUCCESS = "Remove message success!";
    public static string $REMOVE_MESSAGE_FAILED = "Remove message failed!";
    public static string $RESTORE_MESSAGE_SUCCESS = "Restore message success!";
    public static string $RESTORE_MESSAGE_FAILED = "Restore message failed!";
}
