package com.zaleort.second_brain.Users.Domain.User.Exceptions

import com.zaleort.second_brain.Shared.Domain.Error.SecondBrainError

class InvalidCredentialsException(
    message: String = "Invalid credentials",
    status: Int = 401,
    code: String = "INVALID_CREDENTIALS",
) : SecondBrainError(
    message,
    status,
    code,
)