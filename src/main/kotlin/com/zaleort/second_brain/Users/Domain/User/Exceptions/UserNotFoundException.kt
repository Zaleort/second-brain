package com.zaleort.second_brain.Users.Domain.User.Exceptions

import com.zaleort.second_brain.Shared.Domain.Error.SecondBrainError

class UserNotFoundException(
    message: String = "User not found",
    status: Int = 404,
    code: String = "USER_NOT_FOUND",
) : SecondBrainError(
    message,
    status,
    code,
)