package com.zaleort.second_brain.Users.Application.UseCases.Login

data class LoginCommand(
    val email: String,
    val password: String,
)
