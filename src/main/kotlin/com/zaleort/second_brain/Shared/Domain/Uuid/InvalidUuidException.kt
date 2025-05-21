package com.zaleort.second_brain.Shared.Domain.Uuid

import com.zaleort.second_brain.Shared.Domain.Error.SecondBrainError

class InvalidUuidException(
    message: String = "Invalid UUID",
    status: Int = 400,
    code: String = "INVALID_UUID",
) : SecondBrainError(
    message,
    status,
    code,
)

