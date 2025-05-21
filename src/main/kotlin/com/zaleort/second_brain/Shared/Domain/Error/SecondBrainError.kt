package com.zaleort.second_brain.Shared.Domain.Error

open class SecondBrainError(
    message: String = "Internal Server Error",
    val status : Int = 500,
    val code: String? = "INTERNAL_SERVER_ERROR",
) : RuntimeException(message)
