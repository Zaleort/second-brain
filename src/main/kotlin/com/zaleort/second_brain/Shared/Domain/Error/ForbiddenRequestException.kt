package com.zaleort.second_brain.Shared.Domain.Error

class ForbiddenRequestException(
    message: String = "Forbidden request",
    status: Int = 403,
    code: String = "FORBIDDEN_REQUEST",
) : SecondBrainError(
    message,
    status,
    code,
) {
}