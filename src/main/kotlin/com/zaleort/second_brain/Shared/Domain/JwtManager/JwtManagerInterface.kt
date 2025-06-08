package com.zaleort.second_brain.Shared.Domain.JwtManager

interface JwtManagerInterface {
    fun encode(payload: JwtPayload): String
    fun decode(token: String): JwtPayload
    fun renewToken(token: String): String
}