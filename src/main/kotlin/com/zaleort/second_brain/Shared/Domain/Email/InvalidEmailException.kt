package com.zaleort.second_brain.Shared.Domain.Email

import com.zaleort.second_brain.Shared.Domain.Error.SecondBrainError

class InvalidEmailException(
    message: String = "Invalid email address",
    status: Int = 400,
    code: String = "INVALID_EMAIL",
) : SecondBrainError(
    message,
    status,
    code,
) {
}