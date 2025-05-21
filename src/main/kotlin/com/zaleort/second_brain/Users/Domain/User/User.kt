package com.zaleort.second_brain.Users.Domain.User

class User private constructor(
    val id: UserId,
    val email: UserEmail,
    val password: UserPassword,
) {
    companion object {
        fun create(
            id: UserId,
            email: UserEmail,
            password: UserPassword,
        ): User {
            return User(
                id = id,
                email = email,
                password = password,
            )
        }

        fun fromPrimitives(
            id: String,
            email: String,
            password: String,
        ): User {
            return User(
                id = UserId(id),
                email = UserEmail(email),
                password = UserPassword(password),
            )
        }
    }
}